<?php

namespace App\Http\Controllers\SuperAdmin\Product;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Product\ProductRequest;
use App\Models\Service\SuperAdmin\Product\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;
class ProductController extends Controller
{
   protected $product;
    protected $imageController;
    function __construct(ProductService $product, ImageController $imageController)
    {
        $this->product=$product;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $products=$this->product->paginate();
        $show_search='no';
        return view('super-admin.product.index',compact('products'));
    }

    public function create()
    {
        return view('super-admin.product.create');
    }

    public function store(ProductRequest $request)
    {
        $productInfo=$request->all();
        $productInfo['slug'] = Str::slug($request->get('title'));
        $productInfo['order']=DbHelper::nextSortOrder('products');
        $folder_name='Product';
        if($request->file('image')){
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',800,600);
            $productInfo['image']=$ImgName;
        }
        if($this->product->create($productInfo)){
            alert()->success('Product created successfully', 'Success !!!')->persistent('Close');
            // Toastr::success('Product Created Successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }else{
             alert()->error('Problem in creating product', 'Oops !!!')->persistent('Close');
            // Toastr::error('Problem in creating product', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product=$this->product->find($id);
        return view('super-admin.product.edit',compact('product'));
    }
    public function update(ProductRequest $request, $id)
    {
        $productInfo=$request->all();
        $productInfo['slug'] = Str::slug($request->get('title'));
        $product=$this->product->find($id);
        $folder_name='Product';
        if($request->file('image')==''){
            $productInfo['image']=$product->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$product->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',800,600);
            $productInfo['image']=$ImgName;
        }
        if($this->product->update($id, $productInfo)){
            alert()->success('Product updated successfully', 'Success !!!')->persistent('Close');;
//            Toastr::success('Product updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }else{
            Toastr::error('Problem in updating Product', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }
    }
    public function destroy($id)
    {
        $product=$this->product->find($id);
        if($this->product->delete($id)){
            $this->imageController->deleteImg('Product',$product->image);
            Toastr::success('Product deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }else{
            Toastr::error('Problem in deleting product', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('product.index');
        }
    }
    public function search()
    {
        $products=$this->product->search(str_slug($_GET['key']));
        $show_search='no';
        return view('super-admin.product.index',compact('products'));
    }
    
    public function changeProductStatus(Request $request)
    {
        $status = $request->get('status');
        $productId = $request->get('productId');

        if($status == 'active'){

            DB::table('products')->where('id', $productId)->update([
                'status' => 'in_active'
            ]);
        }else{

            DB::table('products')->where('id', $productId)->update([
                'status' => 'active'
            ]);
        }

        return 1;
    }
}
