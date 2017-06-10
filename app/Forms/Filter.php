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
                // this filter already is set and we add active class for it
                $arr_key = array_search($id, $filters[$filters_key]);
                unset($filters[$filters_key][$arr_key]);
                $class = $active_class;
            } else {
                // just append id to the 
                $filters[$filters_key][] = $id;
            }

            $href = route('home', $filters);

            return sprintf(
                '<a href="%s" class="%s" title="%s">%s</a>',
                $href, $class, $text, $text
            );
        });
    }
}