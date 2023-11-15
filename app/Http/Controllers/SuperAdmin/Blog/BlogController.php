<?php

namespace App\Http\Controllers\SuperAdmin\Blog;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\Blog\BlogRequest;
use App\Models\Service\SuperAdmin\Blog\BlogCategoryService;
use App\Models\Service\SuperAdmin\Blog\BlogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use App\Helpers\DbHelper as DbHelper;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $blog;
    protected $imageController;
    protected $blogCat;
    function __construct(BlogService $blog, ImageController $imageController, BlogCategoryService $blogCat)
    {
        $this->blog=$blog;
        $this->imageController=$imageController;
        $this->blogCat=$blogCat;
    }

    public function index()
    {
        $blogs=$this->blog->paginate();
        $show_search='yes';
        return view('super-admin.blog.index',compact('blogs','show_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=$this->blogCat->all();
        return view('super-admin.blog.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required|mimes:jpeg,jpg,png,gif',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $blogInfo=$request->all();
        $blogInfo['slug'] = Str::slug($request->get('title'));
        $blogInfo['order']=DbHelper::nextSortOrder('blogs');
        $folder_name='Blog';

        if($request->file('image')){
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',370,270);
            $blogInfo['image']=$ImgName;
        }
        if($request->file('inner_image')){
            $InnerImgName=$this->imageController->saveAnyImg($request,'Blog/Inner','inner_image',770,430);
            $blogInfo['inner_image']=$InnerImgName;
        }


        if($this->blog->create($blogInfo, $request->file('image'))){
            Toastr::success('Blog created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
        }else{
            Toastr::error('Problem in creating blog', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=$this->blogCat->all();
        $blog=$this->blog->find($id);
        return view('super-admin.blog.edit',compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $id)
    {
        $blogInfo=$request->all();
        $blogInfo['slug']=Str::slug($request->get('title'));

        $folder_name='Blog';
        if($request->file('image')==''){
            $blog=$this->blog->find($id);
            $blogInfo['image']=$blog->image;
        }
        else{
            $blog=$this->blog->find($id);
            $this->imageController->deleteImg($folder_name,$blog->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',370,270);
            $blogInfo['image']=$ImgName;
        }

        if($request->file('inner_image')==''){
            $blog=$this->blog->find($id);
            $blogInfo['inner_image']=$blog->inner_image;
        }
        else{
            $blog=$this->blog->find($id);
            $this->imageController->deleteImg($folder_name,$blog->inner_image);
            $InnerImgName=$this->imageController->saveAnyImg($request,'Blog/Inner','inner_image',770,430);
            $blogInfo['inner_image']=$InnerImgName;
        }

        if($this->blog->update($id, $blogInfo)){
            Toastr::success('Blog updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
        }else{
            Toastr::error('Problem in updating blog', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
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
        $blog=$this->blog->find($id);
        if($this->blog->delete($id)){
            $this->imageController->deleteImg('Blog',$blog->image);
            $this->imageController->deleteImg('Blog/Inner',$blog->inner_image);
            Toastr::success('Blog deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
        }else{
            Toastr::error('Problem in deleting blog', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog.index');
        }
    }
    public function search()
    {
        $blogs=$this->blog->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.blog.index',compact('blogs','show_search'));
    }

}