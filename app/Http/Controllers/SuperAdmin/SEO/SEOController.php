<?php

namespace App\Http\Controllers\SuperAdmin\SEO;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Seo\SeoRequest;
use App\Models\Service\SuperAdmin\Seo\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Kamaln7\Toastr\Facades\Toastr;

class SEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $seo;
    protected $imageController;
    function __construct(SeoService $seo, ImageController $imageController)
    {
        $this->seo=$seo;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $seos=$this->seo->paginate();
        $show_search='yes';
        return view('super-admin.seo.index',compact('seos','show_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.seo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeoRequest $request)
    {
        $seoInfo=$request->all();

        $titleslug = $request->get('slug');
        $seoInfo['title'] = ucwords(str_replace('-', ' ', $titleslug));

        $validator = Validator::make($request->all(), [
            'image'=>'required|mimes:jpeg,jpg,png,gif',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $folder_name='SEO';
        if($request->file('image')){
            $ImgName=$this->imageController->saveSEOImg($request,$folder_name,'image',1920,600);
            $seoInfo['image']=$ImgName;
        }


        if($this->seo->create($seoInfo)){
            Toastr::success('Seo created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }else{
            Toastr::error('Problem in creating seo', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seo=$this->seo->find($id);
        return view('super-admin.seo.edit',compact('seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SeoRequest $request, $id)
    {
        $seoInfo=$request->all();
        $titleslug = $request->get('slug');
        $seoInfo['title'] = ucwords(str_replace('-', ' ', $titleslug));

        $seo=$this->seo->find($id);
        $folder_name='SEO';
        if($request->file('image')==''){
            $seoInfo['image']=$seo->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$seo->image);
            $ImgName=$this->imageController->saveSEOImg($request,$folder_name,'image',1920,600);
            $seoInfo['image']=$ImgName;
        }
        if($this->seo->update($id, $seoInfo)){
            Toastr::success('Seo updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }else{
            Toastr::error('Problem in updating seo', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->seo->delete($id)){
            Toastr::success('Seo deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }else{
            Toastr::error('Problem in deleting seo', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('seo.index');
        }
    }
    public function search()
    {
        $seos=$this->seo->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.seo.index',compact('seos','show_search'));
    }
}
