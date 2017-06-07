<?php namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IRepository
{
    /**
     * Get the table associated with the repository model.
     * @return string
     */
    public function getTable(): string;

    /**
     * Get current repository full model class name.
     * @return string
     */
    public function modelClass(): string;

    /**
     * Set repository queryable ordering.
     * @param string $by
     * @param string $direction
     * @return IRepository|$this
     */
    public function orderBy(
        string $by = 'id', string $direction = 'desc'
    ): IRepository;

    /**
     * Set repository queryable ordering from a request.
     * @param Request $request
     * @param string $defaultOrder
     * @param string $defaultDirection
     * @return IRepository|$this
     */
    public function requestOrdered(
        Request $request, string $defaultOrder = 'id',
        string $defaultDirection = 'asc'
    ): IRepository;

    /**
     * Find single instance of model.
     * @param mixed $id
     * @param array $columns
     * @return Model
     */
    public function find(
        $id, array $columns = ['*']
    ): Model;

    /**
     * Get collection of models.
     * @param array $filters
     * @param array $columns
     * @return Collection
     */
    public function get(
        array $filters = [], array $columns = ['*']
    ): Collection;

    /**
     * Create new instance in of model in database.
     * @param array $input
     * @return Model
     */
    public function create(
        array $input
    ): Model;

    /**
     * Update existing instance in database.
     * @param array $input
     * @param int $id
     * @param Model $model
     * @return Model
     */
    public function update(
        array $input, int $id, Model $model = null
    ): Model;

    /**
     * Delete record in database.
     * @param int $id
     * @return boolean
     */
    public function delete(
        int $id
    ): bool;

    /**
     * Get count of queryable records.
     * @return integer
     */
    public function count(): int;
}