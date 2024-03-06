<?php

namespace Mziel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mziel\Blog\Contracts\BlogImage as BlogImageContract;

class BlogImage extends Model implements BlogImageContract
{
    protected $fillable = ['path', 'blog_id'];

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
