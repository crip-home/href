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
        return $this->getQuery()
            ->join('hrefs', 'users.id', '=', 'hrefs.user_id')
            ->where('hrefs.visible', true)
            ->groupBy('users.id', 'users.name')
            ->having(\DB::raw('COUNT( hrefs.id )'), '>=', $minHrefs)
            ->orderBy('hrefs_count', 'desc')
            ->limit($count)
            ->get([
                'users.id',
                'users.name',
                \DB::raw('COUNT( hrefs.id ) AS hrefs_count')
            ]);
    }
}