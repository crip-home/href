<?php namespace App\Http\Controllers;

use App\Services\HrefService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class HrefController
 * @package App\Http\Controllers
 */
class HrefController extends Controller
{
    /**
     * @param HrefService $hrefService
     * @return Factory|View
     */
    public function index(HrefService $hrefService)
    {
        $tags = $hrefService->getMostUsedTags()->toArray();
        $authors = $hrefService->getMostActiveAuthors()->toArray();

        return view('home')->with(compact('tags', 'authors'));
    }
}