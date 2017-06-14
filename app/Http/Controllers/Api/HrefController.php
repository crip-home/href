<?php namespace App\Http\Controllers\Api;

use App\Services\HrefService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class HrefController
 * @package App\Http\Controllers\Api
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
        $this->middleware('jwt.auth');
        $this->hrefService = $hrefService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id = 0)
    {
        $data = $this->hrefService->filterOwned($id);

        return new JsonResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $href = $this->hrefService->find($id);

        if ($href->url) {
            return new JsonResponse($href);
        }

        return $this->index($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
