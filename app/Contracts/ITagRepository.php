<?php namespace App\Contracts;

use App\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Interface ITagRepository
 * @package App\Repositories
 */
interface ITagRepository extends IRepository
{
    /**
     * Join tags usage count column to the query results.
     * @return Builder
     */
    public function joinHrefUsageCount(): Builder;

    /**
     * Get most used tags.
     * @param int $count
     * @param int $minUsage
     * @return Collection
     */
    public function getMostUsed(int $count, int $minUsage): Collection;

    /**
     * Find or create tag instance in database.
     * @param string $tag
     * @return Tag
     */
    public function findOrCreate(string $tag): Tag;
}