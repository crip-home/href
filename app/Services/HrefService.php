<?php namespace App\Services;

use App\Contracts\ICategoryRepository;
use App\Contracts\IHrefRepository;
use App\Contracts\ITagRepository;
use App\Contracts\IUserRepository;
use App\Href;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Class HrefService
 * @package App\Services
 */
class HrefService
{
    /**
     * @var IHrefRepository
     */
    private $hrefRepository;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @var ITagRepository
     */
    private $tagRepository;

    /**
     * @var ICategoryRepository
     */
    private $categoryRepository;

    /**
     * HrefService constructor.
     * @param IHrefRepository $hrefRepository
     * @param IUserRepository $userRepository
     * @param ITagRepository $tagRepository
     * @param ICategoryRepository $categoryRepository
     */
    public function __construct(
        IHrefRepository $hrefRepository, IUserRepository $userRepository,
        ITagRepository $tagRepository, ICategoryRepository $categoryRepository
    )
    {
        $this->hrefRepository = $hrefRepository;
        $this->userRepository = $userRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get most active user collection.
     * @param  int $count Total count of authors.
     * @param  int $minHrefs Minimum of hrefs posted to be in a list.
     * @return Collection
     */
    public function getMostActiveAuthors(
        int $count = 25, int $minHrefs = 10
    ): Collection
    {
        return $this->userRepository->getMostActiveAuthors($count, $minHrefs);
    }

    /**
     * Get most used tags.
     * @param  int $count
     * @param  int $minUsage
     * @return Collection
     */
    public function getMostUsedTags(
        int $count = 25, int $minUsage = 5
    ): Collection
    {
        return $this->tagRepository->getMostUsed($count, $minUsage);
    }

    /**
     * Get most used categories.
     * @param  int $count
     * @param  int $minUsage
     * @return Collection
     */
    public function getMostUsedCategories(
        int $count = 25, int $minUsage = 10
    ): Collection
    {
        return $this->categoryRepository->getMostUsed($count, $minUsage);
    }

    /**
     * Paginate filtered hrefs.
     * @param  array $authors
     * @param  array $categories
     * @param  array $tags
     * @param  array $params
     * @return Paginator
     */
    public function paginateFiltered(
        array $authors, array $categories, array $tags, array $params
    ): Paginator
    {
        return $this->hrefRepository
            ->withUsersTagsAndCategories()
            ->filterByRelated($authors, $categories, $tags)
            ->onlyVisibleAndOrderedByDate()
            ->paginate()
            ->appends($params);
    }

    /**
     * Group paginator results by days.
     * @param  Paginator $hrefs
     * @param  string $group_by
     * @return array
     */
    public function groupByDays(
        Paginator $hrefs, $group_by = 'date_added'
    ): array
    {
        $groups = [];

        foreach ($hrefs as $href) {
            $group = $href->$group_by->toDateString();

            if (!array_key_exists($group, $groups)) {
                $groups[$group] = [];
            }

            $groups[$group][] = $href;
        }

        return $groups;
    }

    /**
     * Get owned records of one parent element.
     * @param  int $parentId
     * @return Collection
     */
    public function filterOwned(int $parentId = 0): Collection
    {
        return $this->hrefRepository
            ->filterOwner(Auth::user()->id)
            ->filterWhereParent($parentId)
            ->withUsersTagsAndCategories()
            ->orderBy('date_added')
            ->get();
    }

    /**
     * Find single href instance.
     * @param  $id
     * @return Href
     */
    public function find($id)
    {
        /** @var Href $record */
        $record = $this->hrefRepository
            ->withUsersTagsAndCategories()
            ->find($id);

        return $record;
    }

    /**
     * Save new instance of href to database.
     * @param  array $data
     * @return Href
     */
    public function create(array $data): Href
    {
        $data['user_id'] = Auth::user()->id;
        $data['date_added'] = Carbon::now();
        $data['index'] = 1;

        $parentId = $data['parent_id'];
        $tagIds = [];
        while ($parentId != 0) {
            $parent = $this->hrefRepository->find($parentId);
            $tagIds[] = $this->tagRepository->findOrCreate($parent->title)->id;
            $parentId = $parent->parent_id;
        }

        /** @var Href $record */
        $record = $this->hrefRepository->create($data);

        $record->tags()->sync($tagIds);

        $record->category;
        $record->user;

        return $record;
    }

    /**
     * Update instance of href in to database.
     * @param  array $data
     * @param  int $id
     * @return Href
     */
    public function update(array $data, int $id): Href
    {
        /** @var Href $record */
        $record = $this->hrefRepository->update($data, $id);
        $record->category;
        $record->user;

        return $record;
    }

    /**
     * Determines is the href with child records under it.
     * @param  int $id
     * @return bool
     */
    public function hasChildRecords(int $id): bool
    {
        $count = $this->hrefRepository
            ->get([['parent_id', $id]], ['id'])
            ->count();

        return $count > 0;
    }

    /**
     * Determine is the url already registered in the system.
     * @param  string $url
     * @return int|null
     */
    public function urlExists(string $url):?int
    {
        $hrefs = $this->hrefRepository->get([['url', '=', $url]], ['id']);

        if ($hrefs->count()) {
            return $hrefs[0]->id;
        }

        return null;
    }
}