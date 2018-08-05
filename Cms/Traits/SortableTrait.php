<?php

namespace Modules\Cms\Traits;

trait SortableTrait
{
    public function sortablelink($orderBy, $title)
    {
        $sortedBy = request()->query('sortedBy', 'asc');

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
        
        $html = '<a href="'.$href.'">'.
            $title.
            ' <i class="'.$titleIconClass.'"></i>'.
        '</a>';

        return $html;
    }
}