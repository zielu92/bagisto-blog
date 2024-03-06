<?php

namespace Mziel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Mziel\Blog\Contracts\BlogTranslation as BlogTranslationContract;

class BlogTranslation extends Model implements BlogTranslationContract
{
    protected $table = 'blog_translations';

    protected $fillable = ['title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'locale', 'blog_id'];

    protected $hidden = ['meta_title', 'meta_description', 'meta_keywords'];

    public $timestamps = false;


    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
