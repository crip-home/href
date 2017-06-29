<?php namespace App\Services;

use App\Category;
use App\Contracts\ICategoryRepository;
use App\Href;
use App\Repositories\HrefRepository;
use Illuminate\Support\Collection;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService
{
    /**
     * @var ICategoryRepository
     */
    private $categoryRepository;

    /**
     * @var HrefRepository
     */
    private $hrefRepository;

    /**
     * CategoryService constructor.
     * @param ICategoryRepository $categoryRepository
     * @param HrefRepository $hrefRepository
     */
    public function __construct(
        ICategoryRepository $categoryRepository, HrefRepository $hrefRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->hrefRepository = $hrefRepository;
    }

    /**
     * Find single category instance by id.
     * @param  int $id
     * @return Category
     */
    public function find(int $id): Category
    {
        /** @var Category $record */
        $record = $this->categoryRepository->find($id);

        return $record;
    }

    /**
     * Get all records of categories.
     * @return Collection
     */
    public function all(): Collection
    {
        $records = $this->categoryRepository->get();

        return $records;
    }

    /**
     * Create category record.
     * @param  array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        /** @var Category $record */
        $record = $this->categoryRepository->create($data);

        return $record;
    }

    /**
     * Update category record.
     * @param  array $data
     * @param  int $id
     * @return Category
     */
    public function update(array $data, int $id): Category
    {
        /** @var Category $record */
        $record = $this->categoryRepository->update($data, $id);

        return $record;
    }

    /**
     * Guess page category getting it from closest parent value.
     * @param  int $pageId
     * @return Category|null
     */
    public function guessForPageChild(int $pageId): ?Category
    {
        $category = null;
        while ($pageId != 0) {
            /** @var Href $parent */
            $parent = $this->hrefRepository->find($pageId);

            if ($parent->category) {
                return $parent->category;
            }

            $pageId = $parent->parent_id;
        }

        return null;
    }
}