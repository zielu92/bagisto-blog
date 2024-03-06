<?php

namespace Mziel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Mziel\Blog\Contracts\BlogCategoryTranslation as BlogCategoryTranslationContract;

class BlogCategoryTranslation extends Model implements BlogCategoryTranslationContract
{
    protected $table = 'blog_categories_translations';
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'locale', 'blog_category_id'];
    public $timestamps = false;
}
