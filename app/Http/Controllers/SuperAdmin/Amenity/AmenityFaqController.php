<?php

namespace App\Http\Controllers\SuperAdmin\Amenity;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Amenity\AmenityFaqRequest;
use App\Models\Service\SuperAdmin\Amenity\AmenityFaqService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class AmenityFaqController extends Controller
{
    protected $amenityFaq;
    protected $imageController;
    function __construct(AmenityFaqService $amenityFaq, ImageController $imageController)
    {
        $this->amenityFaq=$amenityFaq;
        $this->imageController=$imageController;
    }
    public function index($id)
    {
        $amenityFaqs=$this->amenityFaq->paginate($id);
        $show_search='yes';
        $amenity_id =$id;
        return view('super-admin.amenity.faq.index',compact('amenityFaqs','show_search','amenity_id'));
    }
    public function create($id)
    {
        $amenity_id=$id;
        return view('super-admin.amenity.faq.create',compact('amenity_id'));
    }
    public function store(Request $request)
    {
        $amenityFaqInfo = $request->all();
        $amenityFaqInfo['amenity_id'] = $request->get('amenity_id');
        $amenityFaqInfo['slug'] = Str::slug($request->get('question'));
        $amenityFaqInfo['order'] = DbHelper::nextSortOrder('amenity_faqs');
        if($this->amenityFaq->create($amenityFaqInfo)){
            Toastr::success('Service Faq created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in creating faq', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function edit($id,$amenityId)
    {
        $amenityFaq=$this->amenityFaq->find($id);
        $amenity_id=$amenityId;
        return view('super-admin.amenity.faq.edit',compact('amenityFaq','amenity_id'));
    }
    public function update(AmenityFaqRequest $request, $id)
    {
        $amenityFaqInfo=$request->all();
        $amenityFaqInfo['slug'] = Str::slug($request->get('question'));
        if($this->amenityFaq->update($id, $amenityFaqInfo)){
            Toastr::success('Service Faq updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in updating service faq.', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function destroy($id)
    {
        $amenityFaq=$this->amenityFaq->find($id);
        if($this->amenityFaq->delete($id)){
            Toastr::success('Service Faq deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }else{
            Toastr::error('Problem in deleting faq.', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('service.index');
        }
    }
    public function search()
    {
        $amenityFaqs=$this->amenityFaq->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.amenity.faq.index',compact('amenityFaqs','show_search'));
    }
}
