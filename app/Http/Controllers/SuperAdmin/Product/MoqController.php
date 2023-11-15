<?php

namespace App\Http\Controllers\SuperAdmin\Product;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Product\MoqRequest;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Service\SuperAdmin\Product\MoqService;
use App\Http\Controllers\Controller;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class MoqController extends Controller
{
    protected $imageController;
    protected $moq;
    function __construct(ImageController $imageController, MoqService $moq)
    {
        $this->imageController=$imageController;
        $this->moq=$moq;
    }

    public function index()
    {
        $moqs=$this->moq->paginate();
        return view('super-admin.product.moq.index',compact('moqs'));
    }

    public function create()
    {
        $products = Product::where('status','active')->get();
        return view('super-admin.product.moq.create', compact('products'));
    }
    public function store(Request $request)
    {
        if ($request->get('arrayName')) {
            foreach (($request->get('arrayName')) as $moq) {
                $moqDetails['product_id'] = $moq['product_id'];
                $moqDetails['batch_no'] = $moq['batch_no'];
                $moqDetails['bottle_case'] = $moq['bottle_case'];
                $moqDetails['moq_low'] = $moq['moq_low'];
                $moqDetails['moq_high'] = $moq['moq_high'];
                $moqDetails['rate'] = $moq['rate'];
                $this->moq->create($moqDetails);
            }
            alert()->success('Minimum Order Quantity created successfully', 'Success !!!')->persistent('Close');
//            Toastr::success('Minimum Order Quantity created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('moq.index');
        }
        else{
            alert()->error('Problem in creating Minimum Order Quantity', 'Oops !!!')->persistent('Close');
//            Toastr::error('Problem in creating Minimum Order Quantity', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('moq.index');
        }
    }
    public function edit($id)
    {
        $moq=$this->moq->find($id);
        $products = Product::where('status','active')->get();
        return view('super-admin.product.moq.edit',compact('products', 'moq'));
    }
    public function update(Request $request, $id)
    {
        $moqInfo=$request->all();
        if($this->moq->update($id, $moqInfo)){
            alert()->success('Minimum Order Quantity updated successfully', 'Success !!!')->persistent('Close');;
            return redirect()->route('moq.index');
        }else{
            alert()->error('Problem in updating Minimum Order Quantity', 'Oops !!!')->persistent('Close');;
            return redirect()->route('moq.index');
        }

    }
    public function destroy($id)
    {
        if($this->moq->delete($id)){
            alert()->success('Minimum Order Quantity deleted successfully', 'Success !!!')->persistent('Close');;
//            Toastr::success('Minimum Order Quantity deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('moq.index');
        }else{
            alert()->error('Problem in deleting Minimum Order Quantity', 'Oops !!!')->persistent('Close');;
            return redirect()->route('moq.index');
        }
    }
    public function productBatchDetail(Request $request)
    {
        $productDetail = Product::where('id', $request->productId)->first();
        if($productDetail != null){
            return $productDetail;
        }
        else{
            return 0;
        }
    }

}
