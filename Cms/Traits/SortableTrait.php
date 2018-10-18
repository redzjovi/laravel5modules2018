<?php

namespace Modules\Cms\Traits;

trait SortableTrait
{
    public function sortablelink($orderBy, $title, $options = [])
    {
        request()->query('sortedBy') ? request()->query('sortedBy') : request()->query->set('sortedBy', 'asc');
        $sortedBy = request()->query('sortedBy');

        $sortedByNew = '';
        $sortedByNew = ($sortedBy == 'asc') ? 'desc' : $sortedByNew;
        $sortedByNew = ($sortedBy == 'desc') ? 'asc' : $sortedByNew;

        $href = request()->fullUrlWithQuery([
            'orderBy' => $orderBy,
            'sortedBy' => $sortedByNew,
        ]);

        $titleIconClass = '';
        $titleIconClass = (request()->query('orderBy') == $orderBy && request()->query('sortedBy') == 'asc') ? 'fas fa-sort-up' : $titleIconClass;
        $titleIconClass = (request()->query('orderBy') == $orderBy && request()->query('sortedBy') == 'desc') ? 'fas fa-sort-down' : $titleIconClass;

        $html = '<a '.
            (isset($options['pjax-elements']) ? 'pjax-elements ' : '').
            'href="'.$href.'" '.
        '>'.
            $title.
            ' <i class="'.$titleIconClass.'"></i>'.
        '</a>';

        return $html;
    }
}
