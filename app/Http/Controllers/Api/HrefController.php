<?php namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiHrefStore;
use App\Http\Requests\ApiHrefUpdate;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = $this->hrefService->filterOwned(0);

        return new JsonResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  ApiHrefStore $request
     * @return JsonResponse
     */
    public function store(ApiHrefStore $request): JsonResponse
    {
        $data = $request->only([
            'title', 'url', 'visible', 'category_id', 'parent_id'
        ]);
        $record = $this->hrefService->create($data);

        return new JsonResponse($record);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $href = $this->hrefService->find($id);

        return new JsonResponse($href);
    }

    /**
     * Update the specified resource in storage.
     * @param  ApiHrefUpdate $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(ApiHrefUpdate $request, int $id): JsonResponse
    {
        $data = $request->only([
            'title', 'url', 'visible', 'category_id', 'parent_id', 'index'
        ]);

        $record = $this->hrefService->update($data, $id);

        return new JsonResponse($record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        //
    }
}
