<?php

return [
    [
        'key'   => 'blog',
        'name'  => 'blog::blog.blog',
        'route' => 'admin.blog.index',
        'sort'  => 2
    ],[
        'key'   => 'blog.category',
        'name'  => 'blog::blog.blog-category',
        'route' => 'admin.blog.index',
        'sort'  => 1,
    ], [
        'key'   => 'blog.category.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'admin.blog.category.create',
        'sort'  => 1,
    ], [
        'key'   => 'blog.category.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => 'admin.blog.category.edit',
        'sort'  => 2,
    ], [
        'key'   => 'blog.category.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'admin.blog.category.delete',
        'sort'  => 3,
    ],
    [
        'key'   => 'blog.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'admin.blog.create',
        'sort'  => 2,
    ], [
        'key'   => 'blog.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => 'admin.blog.edit',
        'sort'  => 3,
    ], [
        'key'   => 'blog.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'admin.blog.delete',
        'sort'  => 4,
    ],
];
