<?php namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return Response
     */
    public function index()
    {
        return redirect()->route('admin');
    }

    /**
     * About page
     */
    public function about()
    {
        return view('about');
    }
}
