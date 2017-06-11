<?php namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use View;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends \App\Http\Controllers\Controller
{
    /**
     * Admin panel root.
     * @return Factory|View
     */
    public function index()
    {
        return view('admin');
    }
}