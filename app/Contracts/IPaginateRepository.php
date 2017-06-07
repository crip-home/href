<?php namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class IPaginateRepository
 * @package App\Contracts
 */
interface IPaginateRepository extends IRepository
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
    ): LengthAwarePaginator;
}