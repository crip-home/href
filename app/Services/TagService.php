<?php namespace App\Services;

use App\Contracts\ITagRepository;
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

    public function __construct(ITagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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
}