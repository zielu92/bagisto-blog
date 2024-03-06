<?php

namespace Mziel\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Mziel\Blog\Datagrids\BlogCategoryDatagrid;
use Illuminate\Support\Facades\Event;
use Mziel\Blog\Repositories\BlogCategoryRepository;

class BlogCategoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     public function __construct(protected BlogCategoryRepository $blogCategoryRepository)
     {

     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax()) {
            return app(BlogCategoryDatagrid::class)->toJson();
        }
        return view('blog::admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('blog::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'slug'      => ['required', 'unique:blog_categories_translations,slug', new \Webkul\Core\Rules\Slug],
            'title'   => 'required',
            'channels'     => 'required',
        ]);


        Event::dispatch('blog.categories.create.before');

        $category = $this->blogCategoryRepository->create(request()->only([
            'title',
            'channels',
            'meta_title',
            'slug',
            'meta_keywords',
            'meta_description',
        ]));

        Event::dispatch('blog.categories.create.after', $category);

        session()->flash('success', trans('blog::blog.category-added'));

        return redirect()->route('admin.blog.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $category = $this->blogCategoryRepository->findOrFail($id);

        return view('blog::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $id)
    {
        $locale = core()->getRequestedLocaleCode();

        $this->validate(request(), [
            $locale.'.slug'      => ['required', new \Webkul\Core\Rules\Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->blogCategoryRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('blog::blog.already-taken', ['name' => 'Blog category']));
                }
            }],
            $locale.'.title'     => 'required',
            'channels'           => 'required',
        ]);

        Event::dispatch('blog.category.update.before', $id);

        $category = $this->blogCategoryRepository->update([
            $locale    => request()->input($locale),
            'channels' => request()->input('channels'),
            'locale'   => $locale,
        ], $id);

        Event::dispatch('blog.category.update.after', $category);

        session()->flash('success', trans('blog::blog.category-updated'));

        return redirect()->route('admin.blog.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            Event::dispatch('blog.category.delete.before', $id);

            $this->blogCategoryRepository->delete($id);

            Event::dispatch('blog.category.delete.after', $id);

            return new JsonResponse(['message' => trans('blog::blog.category-deleted')]);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => trans('blog::blog.category-not-found')]);
        }
    }
}
