<?php

namespace Mziel\Blog\Models;

use Webkul\Core\Models\ChannelProxy;
use Webkul\Core\Eloquent\TranslatableModel;
use Mziel\Blog\Contracts\BlogCategory as BlogCategoryContract;

class BlogCategory extends TranslatableModel implements BlogCategoryContract
{

    protected $fillable = ['name'];

    public $translatedAttributes = [
        'title',
        'slug',
        'locale',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $with = ['translations'];

    public function channels()
    {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'blog_categories_channels', 'blog_category_id');
    }

    public function blog() {
        return $this->hasMany(Blog::class);
    }

}
