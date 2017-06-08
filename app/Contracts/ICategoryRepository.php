<?php namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Class ICategoryRepository
 * @package App\Contracts
 */
interface ICategoryRepository extends IRepository
{
    /**
     * Get most used categories.
     * @param int $count
     * @param int $minUsage
     * @return Collection
     */
    public function getMostUsed(int $count, int $minUsage): Collection;
}