<?php

namespace App\Http\Controllers\SuperAdmin\Product;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Product\ProductBatchRequest;
use App\Models\Model\SuperAdmin\Product\ProductBatch;
use App\Models\Service\SuperAdmin\Product\ProductBatchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Alert;

class ProductBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productbatch;

    function __construct(ProductBatchService $productbatch)
    {
        $this->productbatch=$productbatch;
    }

    public function index()
    {
        $batches=$this->productbatch->paginate();
        return view('super-admin.product.productbatch',compact('batches'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductBatchRequest $request, $id)
    {
        $productbatchInfo=$request->all();
        $productbatch=$this->productbatch->find($id);
        if($this->productbatch->update($id, $productbatchInfo)){
            alert()->success('Batch updated successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('productbatch.index');
        }else{
            alert()->error('Problem in updating batch', 'Oops !!!')->persistent('Close');
            return redirect()->route('productbatch.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $productbatch=$this->productbatch->find($id);
        if($this->productbatch->delete($id)){
            alert()->success('Batch deleted successfully', 'Success !!!')->persistent('Close');
//            Toastr::success('Batch deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('productbatch.index');
        }else{
            alert()->error('Problem in deleting batch.', 'Oops !!!')->persistent('Close');
//            Toastr::error('Problem in deleting batch', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('productbatch.index');
        }
    }

    function insert(Request $request)
    {
        if($request->ajax())
        {
            $rules = array(
                'batch_no.*'  => 'required',
                'bottle_case.*'  => 'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $batch_no = $request->batch_no;
            $bottle_case = $request->bottle_case;
            for($count = 0; $count < count($batch_no); $count++)
            {
                $data = array(
                    'batch_no' => $batch_no[$count],
                    'bottle_case' => $bottle_case[$count],
                );
                $insert_data[] = $data;
            }
            ProductBatch::insert($insert_data);
            return response()->json([

                'success'  => 'Batches added successfully.'
            ]);
        }
    }
}
