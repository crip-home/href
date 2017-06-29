<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiCategoryStore;
use App\Http\Requests\ApiCategoryUpdate;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Api
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * HrefController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('jwt.auth');
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = $this->categoryService->all();

        return new JsonResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  ApiCategoryStore $request
     * @return JsonResponse
     */
    public function store(ApiCategoryStore $request): JsonResponse
    {
        $data = $request->only('title');
        $record = $this->categoryService->create($data);

        return new JsonResponse($record);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $record = $this->categoryService->find($id);

        return new JsonResponse($record);
    }

    /**
     * Update the specified resource in storage.
     * @param  ApiCategoryUpdate $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(ApiCategoryUpdate $request, int $id): JsonResponse
    {
        $data = $request->only('title');
        $record = $this->categoryService->update($data, $id);

        return new JsonResponse($record);
    }

    /**
     * Guess category for page child element.
     * @param  int $pageId
     * @return JsonResponse
     */
    public function guess(int $pageId): JsonResponse
    {
        $category = $this->categoryService->guessForPageChild($pageId);

        return new JsonResponse($category);
    }
}