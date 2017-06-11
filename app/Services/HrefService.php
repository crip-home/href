<?php namespace App\Services;

use App\Contracts\ICategoryRepository;
use App\Contracts\IHrefRepository;
use App\Contracts\ITagRepository;
use App\Contracts\IUserRepository;
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
     * @param int $count
     * @param int $minUsage
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
     * @param int $count
     * @param int $minUsage
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
     * @param array $authors
     * @param array $categories
     * @param array $tags
     * @param array $params
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
     * @param Paginator $hrefs
     * @param string $group_by
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
}