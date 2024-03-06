<?php

namespace Mziel\Blog\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BlogCategoryDatagrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $whereInLocales = core()->getRequestedLocaleCode() === 'all'
        ? core()->getAllLocales()->pluck('code')->toArray()
        : [core()->getRequestedLocaleCode()];

    $queryBuilder = DB::table('blog_categories')
        ->select(
            'blog_categories.id',
            'blog_categories_translations.title',
            'blog_categories_translations.slug'
        )
        ->join('blog_categories_translations', function ($leftJoin) use ($whereInLocales) {
            $leftJoin->on('blog_categories.id', '=', 'blog_categories_translations.blog_category_id')
                ->whereIn('blog_categories_translations.locale', $whereInLocales);
        });

    $this->addFilter('id', 'blog_categories.id');

    return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {

        $this->addColumn([
            'index'      => 'id',
            'label'      => 'Id',
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('blog::blog.title'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'slug',
            'label'      => trans('blog::blog.slug'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon'   => 'icon-view',
            'title'  => trans('blog::blog.view-category'),
            'method' => 'GET',
            'index'  => 'slug',
            'target' => '_blank',
            'url'    => function ($row) {
                return route('shop.blog.category.show', $row->slug);
            },
        ]);

        if (bouncer()->hasPermission('blog.category.edit')) {
            $this->addAction([
                'icon'   => 'icon-edit',
                'title'  => trans('blog::blog.edit-category'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.blog.category.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('blog.category.delete')) {
            $this->addAction([
                'icon'   => 'icon-delete',
                'title'  => trans('blog::blog.delete-category'),
                'method' => 'DELETE',
                'url'    => function ($row) {
                    return route('admin.blog.category.delete', $row->id);
                },
            ]);
        }
    }
}
