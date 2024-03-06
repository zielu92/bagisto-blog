<?php

namespace Mziel\Blog\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BlogDatagrid extends DataGrid
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

        $queryBuilder = DB::table('blogs')
            ->select(
                'blogs.id',
                'blog_translations.title',
                'blog_translations.slug'
            )
            ->join('blog_translations', function ($leftJoin) use ($whereInLocales) {
                $leftJoin->on('blogs.id', '=', 'blog_translations.blog_id')
                    ->whereIn('blog_translations.locale', $whereInLocales);
            });

        $this->addFilter('id', 'blogs.id');

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
            'title'  => trans('blog::blog.view-blog'),
            'method' => 'GET',
            'index'  => 'slug',
            'target' => '_blank',
            'url'    => function ($row) {
                return route('shop.blog.show', $row->slug);
            },
        ]);

        if (bouncer()->hasPermission('blog.edit')) {
            $this->addAction([
                'icon'   => 'icon-edit',
                'title'  => trans('blog::blog.edit-blog'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.blog.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('blog.delete')) {
            $this->addAction([
                'icon'   => 'icon-delete',
                'title'  => trans('blog::blog.delete-blog'),
                'method' => 'DELETE',
                'url'    => function ($row) {
                    return route('admin.blog.delete', $row->id);
                },
            ]);
        }
    }

     /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        if (bouncer()->hasPermission('blog.delete')) {
            $this->addMassAction([
                'title'  => trans('blog::blog.delete-blog'),
                'method' => 'POST',
                'url'    => route('admin.blog.mass_delete'),
            ]);
        }
    }


}
