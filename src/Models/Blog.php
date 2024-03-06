<?php

namespace Mziel\Blog\Models;

use Mziel\Blog\Models\BlogImage;
use Webkul\Core\Models\ChannelProxy;
use Webkul\Core\Eloquent\TranslatableModel;
use Mziel\Blog\Contracts\Blog as BlogContract;

class Blog extends TranslatableModel implements BlogContract
{
    protected $table = 'blogs';
    protected $fillable = ['blog_category_id', 'status'];

    public $translatedAttributes = ['title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'locale'];

    protected $with = ['translations'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function publishedDate()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function channels() {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'blog_channels');
    }

    public function image() {
        return $this->belongsTo(BlogImage::class, 'id', 'blog_id');
    }

}
