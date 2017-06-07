<?php namespace App\Repositories;

use App\Contracts\IPaginateRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PaginateRepository
 * @package App\Repositories
 */
abstract class PaginateRepository
    extends Repository
    implements IPaginateRepository
{
    /**
     * Paginate collection of models
     * @param int $perPage
     * @param array $filters
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(
        int $perPage = 15, array $filters = [], array $columns = ['*']
    ): LengthAwarePaginator
    {
        $this->filter($filters);

        $result = $this->getQuery()->paginate($perPage, $columns);

        $this->resetQuery();

        return $result;
    }
}