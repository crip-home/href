<?php namespace App\Repositories;

use App\Contracts\IUserRepository;
use App\User;
use Illuminate\Support\Collection;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository implements IUserRepository
{
    /**
     * Get current repository model full class name.
     * @return string
     */
    function modelClass(): string
    {
        return User::class;
    }

    /**
     * Get most active authors.
     * @param int $count
     * @param int $minHrefs
     * @return Collection
     */
    public function getMostActiveAuthors(int $count, int $minHrefs): Collection
    {

    }
}