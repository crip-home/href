<?php namespace App\Contracts;

use Illuminate\Support\Collection;

/**
 * Class IUserRepository
 * @package App\Contracts
 */
interface IUserRepository extends IRepository
{
    /**
     * Get most active authors.
     * @param int $count
     * @param int $minHrefs
     * @return Collection
     */
    public function getMostActiveAuthors(int $count, int $minHrefs): Collection;
}