<?php namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class HrefController
 * @package App\Http\Controllers
 */
class HrefController extends Controller
{
    /**
     * @param TagService $tagService
     * @return Factory|View
     */
    public function index(TagService $tagService)
    {
        $tags = $tagService->getMostUsed();
        return view('home');
    }
}