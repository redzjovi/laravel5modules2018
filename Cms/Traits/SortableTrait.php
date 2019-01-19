<?php

namespace Modules\Cms\Traits;

trait SortableTrait
{
    public function sortablelink($orderBy, $title, $options = [])
    {
        $titleIconClass = '';

        $sorts = explode(',', request()->query('sort'));
        foreach ($sorts as $i => $sort) {
            if ($sort == $orderBy) {
                $sorts[$i] = '-'.$orderBy;
                $titleIconClass = 'fas fa-sort-up';
            } elseif ($sort == '-'.$orderBy) {
                $sorts[$i] = $orderBy;
                $titleIconClass = 'fas fa-sort-down';
            } else {
                $sorts[$i] = $orderBy;
            }
        }

        $href = request()->fullUrlWithQuery([
            'sort' => implode(',', $sorts),
        ]);

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
