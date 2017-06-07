<?php namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

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
}