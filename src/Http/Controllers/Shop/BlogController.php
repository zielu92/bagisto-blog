<?php

namespace Mziel\Blog\Http\Controllers\Shop;

use Mziel\Blog\Models\Blog;
use Illuminate\Routing\Controller;
use Mziel\Blog\Models\BlogTranslation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Mziel\Blog\Models\BlogCategory;
use Mziel\Blog\Models\BlogCategoryTranslation;

class BlogController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $locale =  app()->getLocale();
        $categories = BlogCategoryTranslation::where('locale', $locale)->get();
        $blogs = BlogTranslation::where('locale', $locale)->paginate(30);
        return view('blog::shop.index', compact('categories', 'blogs'));
    }

    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $blog = BlogTranslation::where('slug', $slug)->where('locale', app()->getLocale())->firstOrFail();
        $blogRaw = Blog::findOrFail($blog->blog_id);
        $nextBlog = null;
        if(Blog::where('id', '>', $blogRaw->id)->first()) {
            $nextBlog = Blog::where('id', '>', $blogRaw->id)->first()->translations->where('locale',app()->getLocale())->first()->slug;
        }
        $prevBlog = null;
        if(Blog::where('id', '<', $blogRaw->id)->first()) {
            $prevBlog = Blog::where('id', '<', $blogRaw->id)->first()->translations->where('locale',app()->getLocale())->first()->slug;
        }
        return view('blog::shop.show', compact('blog', 'blogRaw', 'nextBlog', 'prevBlog'));
    }

    /**
     * show blog category
     *
     * @param  mixed $slug
     * @return void
     */
    public function showCategory($slug)
    {
        $locale =  app()->getLocale();
        $category = BlogCategoryTranslation::where('slug', $slug)->where('locale', $locale)->firstOrFail();
        $categories = BlogCategoryTranslation::where('locale', $locale)->get();
        $blogsRaw = Blog::where('blog_category_id', $category->blog_category_id)->get();
        $blogs = BlogTranslation::whereIn('blog_id', $blogsRaw->pluck('id'))->where('locale', $locale)->paginate(30);
        return view('blog::shop.index', compact('categories', 'blogs'));
    }
}
