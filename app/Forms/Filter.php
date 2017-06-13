<?php namespace App\Forms;

use Form;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Filter
 * @package App\Forms
 */
class Filter
{
    public static function register()
    {
        Form::macro('filter', function (
            $id, $text, $filters = [], $filtersKey,
            $activeClass = 'label label-primary'
        ) {
            if (!$filters) {
                $filters = [];
            }

            if (!is_array($filters[$filtersKey])) {
                $filters[$filtersKey] = [];
            }

            $isActive = '';

            if (in_array($id, $filters[$filtersKey])) {
                // This filter already is set and we add active class for it.
                // Additionally we remove it from filters to toggle this filter
                $arrKey = array_search($id, $filters[$filtersKey]);
                unset($filters[$filtersKey][$arrKey]);
                $isActive = $activeClass;
            } else {
                // Just append id to the filters list.
                $filters[$filtersKey][] = $id;
            }

            $href = route('index', $filters);

            return sprintf(
                '<a href="%s" class="%s" title="%s">%s</a>',
                $href, $isActive, $text, $text
            );
        });
    }
}