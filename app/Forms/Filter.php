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
            $id, $text, $filters = [], $filters_key,
            $class = 'label label-info', $active_class = 'label label-primary'
        ) {
            if (!$filters) {
                $filters = [];
            }

            if (!is_array($filters[$filters_key])) {
                $filters[$filters_key] = [];
            }

            if (in_array($id, $filters[$filters_key])) {
                // This filter already is set and we add active class for it.
                // Additionally we remove it from filters to toggle this filter
                $arr_key = array_search($id, $filters[$filters_key]);
                unset($filters[$filters_key][$arr_key]);
                $class = $active_class;
            } else {
                // Just append id to the filters list.
                $filters[$filters_key][] = $id;
            }

            $href = route('index', $filters);

            return sprintf(
                '<a href="%s" class="%s" title="%s">%s</a>',
                $href, $class, $text, $text
            );
        });
    }
}