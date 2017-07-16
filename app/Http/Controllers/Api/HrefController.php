<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiHrefStore;
use App\Http\Requests\ApiHrefUpdate;
use App\Services\HrefService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @var TagService
     */
    private $tagService;

    /**
     * HrefController constructor.
     * @param HrefService $hrefService
     * @param TagService $tagService
     */
    public function __construct(
        HrefService $hrefService, TagService $tagService
    )
    {
        $this->middleware('jwt.auth');
        $this->hrefService = $hrefService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(['success' => true]);
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
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        //
    }

    /**
     * Fetch title from remote page.
     * @param  Request $request
     * @return JsonResponse
     */
    public function title(Request $request): JsonResponse
    {
        if ($id = $this->hrefService->urlExists($request->url)) {
            // return error in case if someone already has registered this url
            // in system
            return new JsonResponse($this->hrefService->find($id), 422);
        }

        $title = '';
        $str = file_get_contents($request->url);
        if ($str) {
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $output);
            if (array_key_exists(1, $output)) {
                $title = $output[1];
            }
        }

        return new JsonResponse(compact('title'));
    }

    /**
     * Get tags for a page.
     * @param  int $pageId
     * @return JsonResponse
     */
    public function tags(int $pageId): JsonResponse
    {
        $tags = $this->tagService->getForPage($pageId);

        return new JsonResponse($tags);
    }

    /**
     * Check href existence in the system.
     * @param  Request $request
     * @return JsonResponse
     */
    public function exists(Request $request): JsonResponse
    {
        if ($this->hrefService->urlExists($request->url)) {
            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }

    /**
     * Create href for Chrome bookmarks app.
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        if ($this->hrefService->urlExists($request->url)) {
            return new JsonResponse('URL already exists.', 422);
        }

        $data = $request->only([
            'title', 'url', 'tags', 'date'
        ]);

        $record = $this->hrefService->createFromChrome($data);

        return new JsonResponse($record);
    }

    /**
     * @param  int $id
     * @return JsonResponse
     */
    public function list(int $id): JsonResponse
    {
        $data = $this->hrefService->filterOwned($id);

        return new JsonResponse($data);
    }
}
