<?php namespace App\Forms;

use App\Forms\Filter;

/**
 * Class FormMacro
 * @package App\Forms
 */
class FormMacro
{
    /**
     * Register al form macros in application.
     * @return void
     */
    public function register()
    {
        Filter::register();
    }
}