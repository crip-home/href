<?php namespace App\Services;

use App\Category;
use App\Contracts\ICategoryRepository;
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
     * CategoryService constructor.
     * @param ICategoryRepository $categoryRepository
     */
    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
}