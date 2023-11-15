<?php

namespace App\Http\Controllers\FrontEnd\Blog;

use App\Models\Model\SuperAdmin\Blog\Blog;
use App\Models\Model\SuperAdmin\Blog\BlogCategory;
use App\Models\Model\SuperAdmin\Seo\Seo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['blogs']= Blog::where('status', 'active')
            ->orderBy('order', 'desc')
            ->get();
        $data['model'] = Seo::where('slug', 'blogs')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }

        return view('front-end.blog.index',$data);
    }

    public function getDetail($slug)
    {
        $data['image'] = Seo::where('slug', 'blogs')->first()->image;

        $data['model']=$blog=Blog::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
        $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
        $data['meta_keywords'] = $data['model']->seo_keywords;
        $data['meta_description'] = $data['model']->seo_description;

        $data['categories']=BlogCategory::get();

        $data['recent_blogs'] = Blog::where('status', 'active')
            ->where('slug', '!=', $blog->slug)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $tags=[];
        $blogTags=Blog::where('status', 'active')->get();
        foreach ( $blogTags as $tag)
        {
            foreach (explode(',',$tag->tags) as $uniqueTag)
            {
                if(in_array($uniqueTag,$tags))
                {

                }else{

                    $tags[]=$uniqueTag;
                }
            }
        }
        return view('front-end.blog.single',$data,compact('tags'));
    }
    public function getBlogByCategory($slug)
    {
        $category=BlogCategory::where('slug',$slug)->firstOrFail();
        $data['blogs'] = Blog::where('status', 'active')
            ->where('category_id',$category->id)
            ->orderBy('title', 'asc')
            ->paginate(6);
        $data['model'] = Seo::where('slug', 'blogs')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }
        $data['categories'] = BlogCategory::get();
        return view('front-end.blog.index',$data);
    }
    public function getBlogByTag($tag)
    {
        $data['blogs']=DB::table('blogs')->WhereRaw('FIND_IN_SET("'.$tag.'",tags)')->paginate(6);
        $data['model'] = Seo::where('slug', 'blogs')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }
        return view('front-end.blog.index',$data);
    }
    public function search()
    {
        $key=\Illuminate\Support\Facades\Request::get('search');
        $data['blogs']=Blog::where('status','active')->where ( 'title', 'LIKE', '%' . $key . '%' )->orWhere ( 'content', 'LIKE', '%' . $key . '%' )->paginate(3);
        $data['model'] = Seo::where('slug', 'blogs')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }
        $search='yes';
        $data['categories'] = BlogCategory::get();
        return view('front-end.blog.index',$data,compact('key','search'));
    }
}
