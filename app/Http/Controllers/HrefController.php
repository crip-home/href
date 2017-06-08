<?php namespace App\Http\Controllers;

use App\Services\HrefService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use View;

/**
 * Class HrefController
 * @package App\Http\Controllers
 */
class HrefController extends Controller
{
    /**
     * @var HrefService
     */
    private $hrefService;

    /**
     * HrefController constructor.
     * @param HrefService $hrefService
     */
    public function __construct(HrefService $hrefService)
    {
        $this->hrefService = $hrefService;

        $tags = $hrefService->getMostUsedTags();
        $authors = $hrefService->getMostActiveAuthors();
        $categories = $hrefService->getMostUsedCategories();

        View::share(compact('tags', 'authors', 'categories'));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        // t - tags
        // a - authors
        // c - categories
        $filters = $request->only('t', 'a', 'c');

        $paging = $this->hrefService->paginateFiltered(
            $filters['a'], $filters['c'], $filters['t']
        );

        $days = $this->hrefService->groupByDays($paging);

        return view('home')->with(compact('days', 'paging', 'filters'));
    }
}