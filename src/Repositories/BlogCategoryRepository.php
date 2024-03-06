<?php

namespace Mziel\Blog\Repositories;

use Webkul\Core\Eloquent\Repository;
use Mziel\Blog\Models\BlogCategoryTranslation;
use Mziel\Blog\Models\BlogCategoryTranslationProxy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogCategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Mziel\Blog\Models\BlogCategory';
    }

      /**
     * @return \Mziel\Blog\Contracts\BlogCategory
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
        }

        $category = parent::create($data);

        $category->channels()->sync($data['channels']);

        return $category;
    }

    /**
     * @param  int  $id
     * @param  string  $attribute
     * @return \Mziel\Blog\Contracts\BlogCategory
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        $page = $this->find($id);

        $locale = $data['locale'] ?? app()->getLocale();


        parent::update($data, $id, $attribute);

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
        $exists = BlogCategoryTranslation::where('blog_category_id', '<>', $id)
            ->where('slug', $urlKey)
            ->limit(1)
            ->select('id')
            ->exists();

        return ! $exists;
    }

    /**
     * Retrieve category from slug
     *
     * @param  string  $urlKey
     * @return \Mziel\Blog\Contracts\BlogCategory
     */
    public function findByUrlKey($urlKey)
    {
        return $this->model->whereTranslation('slug', $urlKey)->first();
    }

    /**
     * Retrieve category from slug
     *
     * @param  string  $urlKey
     * @return \Mziel\Blog\Contracts\BlogCategory|\Exception
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
}
