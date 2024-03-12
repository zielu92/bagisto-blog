<?php

namespace Mziel\Blog\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Mziel\Blog\Models\BlogCategory;
use Illuminate\Support\Facades\Event;
use Mziel\Blog\Datagrids\BlogDatagrid;
use Mziel\Blog\Repositories\BlogRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(protected BlogRepository $blogRepository)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(BlogDatagrid::class)->toJson();
        }

        return view('blog::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = BlogCategory::all()->pluck('title', 'id');
        return view('blog::admin.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'slug'    => ['required', 'unique:blog_translations,slug', new \Webkul\Core\Rules\Slug],
            'title'   => 'required',
            'channels'=> 'required',
            'content' => 'required',
            'status'  => 'nullable'
        ]);

        Event::dispatch('blog.create.before');

        $page = $this->blogRepository->create(request()->only([
            'blog_category_id',
            'title',
            'channels',
            'image',
            'content',
            'meta_title',
            'slug',
            'meta_keywords',
            'meta_description',
            'status',
        ]));

        Event::dispatch('blog.create.after', $page);

        session()->flash('success', trans('blog::blog.blog-added'));

        return redirect()->route('admin.blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $blog = $this->blogRepository->findOrFail($id);
        $categories = BlogCategory::all()->pluck('title', 'id');
        return view('blog::admin.edit', compact('blog', 'categories'));
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
                if (! $this->blogRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('blog::blog.already-taken', ['name' => 'Blog post']));
                }
            }],
            $locale.'.title'     => 'required',
            'channels'           => 'required',
            $locale.'.content'   => 'required',
            $locale.'.status'    => 'nullable',
        ]);

        Event::dispatch('blog.update.before', $id);

        $blog = $this->blogRepository->update([
            $locale    => request()->input($locale),
            'channels' => request()->input('channels'),
            'status'   => request()->input('status') != null ? 1 : 0,
            'locale'   => $locale,
        ], $id);

        Event::dispatch('blog.update.after', $blog);

        session()->flash('success', trans('blog::blog.blog-updated'));
        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            Event::dispatch('blog.delete.before', $id);

            $this->blogRepository->delete($id);

            Event::dispatch('blog.delete.after', $id);

            return new JsonResponse(['message' => trans('blog::blog.blog-deleted')]);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => trans('blog::blog.blog-not-found')]);
        }
    }

    /**
     *  Mass delete of posts from db
     *
     * @return void
     */
    public function massDelete(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $indices = $massDestroyRequest->input('indices');

        foreach ($indices as $i) {
            Event::dispatch('blog.delete.before', $i);

            $this->blogRepository->delete($i);

            Event::dispatch('blog.delete.after', $i);
        }

        return new JsonResponse([
            'message' => trans('blog::blog.category-deleted'),
        ], 200);
    }
}
