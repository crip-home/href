<?php namespace App\Services;

use App\Contracts\IHrefRepository;
use App\Contracts\ITagRepository;
use App\Href;
use App\Tag;

/**
 * Class TagsService
 * @package App\Services
 */
class TagService
{
    /**
     * @var ITagRepository
     */
    private $tagRepository;

    /**
     * @var IHrefRepository
     */
    private $hrefRepository;

    /**
     * TagService constructor.
     * @param ITagRepository $tagRepository
     * @param IHrefRepository $hrefRepository
     */
    public function __construct(
        ITagRepository $tagRepository, IHrefRepository $hrefRepository
    )
    {
        $this->tagRepository = $tagRepository;
        $this->hrefRepository = $hrefRepository;
    }

    /**
     * Save tag instance in database.
     * @param array $input
     * @return Tag
     */
    public function create(array $input): Tag
    {
        /** @var Tag $model */
        $model = $this->tagRepository->create($input);

        return $model;
    }

    /**
     * Get tags list for page.
     * @param  int $pageId
     * @return array
     */
    public function getForPage(int $pageId): array
    {
        $tags = [];
        while ($pageId != 0) {
            /** @var Href $parent */
            $parent = $this->hrefRepository->find($pageId);
            $tags[] = $this->tagRepository->findOrCreate($parent->title);
            $pageId = $parent->parent_id;
        }

        return $tags;
    }
}