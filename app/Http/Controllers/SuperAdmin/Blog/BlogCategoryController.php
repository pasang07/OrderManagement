<?php

namespace App\Http\Controllers\SuperAdmin\Blog;

use App\Http\Requests\SuperAdmin\Blog\BlogCategoryRequest;
use App\Models\Service\SuperAdmin\Blog\BlogCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $blogCategory;

    function __construct(BlogCategoryService $blogCategory)
    {
        $this->blogCategory = $blogCategory;
    }

    public function index()
    {
        $categories=$this->blogCategory->paginate();
        $show_search='yes';
        return view('super-admin.blog.blog-category',compact('categories','show_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $request)
    {
        $blogCategoryInfo = $request->all();
        $blogCategoryInfo['slug'] = Str::slug($request->get('title'));

        if($this->blogCategory->create($blogCategoryInfo)){
            Toastr::success('Category Add successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        }else{
            Toastr::error('Problem in adding blog category', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryRequest $request, $id)
    {
        $blogCategoryInfo = $request->all();
        $blogCategoryInfo['slug'] = Str::slug($request->get('title'));

        if($this->blogCategory->update($id,$blogCategoryInfo)){
            Toastr::success('Category Update successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        }else{
            Toastr::error('Problem in updating blog category', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->blogCategory->delete($id)) {
            Toastr::success('Category deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        } else {
            Toastr::error('Problem in deleting blog category', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('blog-cat.index');
        }
    }
    public function search()
    {
        $categories=$this->blogCategory->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.blog.blog-category',compact('categories','show_search'));
    }
}
