<?php namespace App\Services;

use App\Contracts\ITagRepository;
use App\Tag;
use Illuminate\Support\Collection;

/**
 * Class TagsService
 * @package App\Services
 */
class TagsService
{
    /**
     * @var ITagRepository
     */
    private $tagRepository;

    public function __construct(ITagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get most used tags.
     * @param int $count
     * @param int $minUsage
     * @return Collection
     */
    public function getMostUsed(int $count = 25, int $minUsage = 5): Collection
    {
        return $this->tagRepository
            ->joinHrefUsageCount()
            ->where('tag_count', '>', $minUsage)
            ->orderBy('tag_count', 'desc')
            ->limit($count)
            ->get();
    }

    /**
     * Save tag instance in database.
     * @param Tag $tag
     * @return Tag
     */
    public function create(Tag $tag): Tag
    {
        /** @var Tag $model */
        $model = $this->tagRepository->create($tag->toArray());

        return $model;
    }
}