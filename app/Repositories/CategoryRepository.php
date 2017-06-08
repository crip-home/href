<?php namespace App\Repositories;

use App\Category;
use App\Contracts\ICategoryRepository;
use Illuminate\Support\Collection;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository extends Repository implements ICategoryRepository
{
    /**
     * Get current repository model full class name.
     * @return string
     */
    function modelClass(): string
    {
        return Category::class;
    }

    /**
     * Get most used categories.
     * @param int $count
     * @param int $minUsage
     * @return Collection
     */
    public function getMostUsed(int $count, int $minUsage): Collection
    {
        return $this->getQuery()
            ->join('hrefs', 'hrefs.category_id', '=', 'categories.id')
            ->where('hrefs.visible', true)
            ->groupBy('categories.id', 'categories.title')
            ->having(\DB::raw('COUNT( hrefs.id )'), '>=', $minUsage)
            ->orderBy('usages', 'desc')
            ->limit($count)
            ->get([
                'categories.id',
                'categories.title',
                \DB::raw('COUNT(`hrefs`.`id`) AS `usages`')
            ]);
    }
}