<?php

namespace Mziel\Blog\Repositories;

use Mziel\Blog\Models\BlogImage;
use Webkul\Core\Eloquent\Repository;
use Mziel\Blog\Models\BlogTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Mziel\Blog\Models\Blog';
    }

     /**
     * @return \Mziel\Blog\Contracts\Blog
     */
    public function create(array $data)
    {
        $model = $this->getModel();

        foreach (core()->getAllLocales() as $locale) {
            foreach ($model->translatedAttributes as $attribute) {
                if (isset($data[$attribute])) {
                    $data[$locale->code][$attribute] = $data[$attribute];
                }
            }

            $data[$locale->code]['content'] = str_replace('=&gt;', '=>', $data[$locale->code]['content']);
        }

        $blog = parent::create($data);
        $this->photoUpload(request()->all(), $blog->id);
        $blog->channels()->sync($data['channels']);

        return $blog;
    }

    /**
     * @param  int  $id
     * @param  string  $attribute
     * @return \Mziel\Blog\Contracts\Blog
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        $page = $this->find($id);

        $locale = $data['locale'] ?? app()->getLocale();

        $data[$locale]['content'] = str_replace('=&gt;', '=>', $data[$locale]['content']);

        parent::update($data, $id, $attribute);

        $this->photoUpload(request()->all(), $id);
        $page->channels()->sync($data['channels']);

        return $page;
    }

    /**
     * Checks slug is unique or not based on locale
     *
     * @param  int  $id
     * @param  string  $urlKey
     * @return bool
     */
    public function isUrlKeyUnique($id, $urlKey)
    {
        $exists = BlogTranslation::class::where('blog_id', '<>', $id)
            ->where('slug', $urlKey)
            ->limit(1)
            ->select(\DB::raw(1))
            ->exists();

        return ! $exists;
    }

    /**
     * Retrieve category from slug
     *
     * @param  string  $urlKey
     * @return \Mziel\Blog\Contracts\Blog
     */
    public function findByUrlKey($urlKey)
    {
        return $this->model->whereTranslation('slug', $urlKey)->first();
    }

    /**
     * Retrieve category from slug
     *
     * @param  string  $urlKey
     * @return \Mziel\Blog\Contracts\Blog|\Exception
     */
    public function findByUrlKeyOrFail($urlKey)
    {
        $page = $this->model->whereTranslation('slug', $urlKey)->first();

        if ($page) {
            return $page;
        }

        throw (new ModelNotFoundException)->setModel(
            get_class($this->model), $urlKey
        );
    }

    private function photoUpload($data, $blog_id){
        $type = "image";
        $dir = 'blog';

        if (isset($data[$type])) {
            $request = request();
            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                if ($request->hasFile($file)) {
                    //remove old picture
                    $img = BlogImage::where('blog_id', $blog_id)->first();
                    if($img!=null) {
                        $img->delete();
                    }
                    $blogImage = new BlogImage();
                    $blogImage->{'path'} = $request->file($file)->store($dir);
                    $blogImage->{'blog_id'} = $blog_id;
                    $blogImage->save();
                }
            }
        }
        if(!isset($data[$type])) {
            $img = BlogImage::where('blog_id', $blog_id)->first();
            if($img!=null) {
                $img->delete();
            }
        }
    }
}

