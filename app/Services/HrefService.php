<?php namespace App\Services;

use App\Contracts\IHrefRepository;
use App\Contracts\ITagRepository;
use App\Contracts\IUserRepository;
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
     * HrefService constructor.
     * @param IHrefRepository $hrefRepository
     * @param IUserRepository $userRepository
     * @param ITagRepository $tagRepository
     */
    public function __construct(
        IHrefRepository $hrefRepository, IUserRepository $userRepository,
        ITagRepository $tagRepository
    )
    {
        $this->hrefRepository = $hrefRepository;
        $this->userRepository = $userRepository;
        $this->tagRepository = $tagRepository;
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
        return $this->hrefRepository->getMostActiveAuthors($count, $minHrefs);
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
}