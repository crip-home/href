<?php namespace App\Repositories;

use App\Contracts\IRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository implements IRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var  Builder
     */
    protected $query;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->modelClass());
    }

    /**
     * Get the table associated with the repository model.
     * @return string
     */
    public function getTable(): string
    {
        return $this->model->getTable();
    }

    /**
     * Get current repository model full class name.
     * @return string
     */
    abstract function modelClass(): string;

    /**
     * Set repository queryable ordering.
     * @param string $by
     * @param string $direction
     * @return IRepository|$this
     */
    public function orderBy(
        string $by = 'id', string $direction = 'desc'
    ): IRepository
    {
        $this->query = $this->getQuery()->orderBy($by, $direction);

        return $this;
    }

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
    ): IRepository
    {
        $order = $request->sort_order ?: $defaultOrder;
        $direction = $request->sort_direction ?: $defaultDirection;

        $this->orderBy($order, $direction);

        return $this;
    }

    /**
     * Find single instance of model.
     * @param mixed $id
     * @param array $columns
     * @return Model
     */
    public function find(
        $id, array $columns = ['*']
    ): Model
    {
        $result = $this->getQuery()->findOrFail($id, $columns);

        $this->resetQuery();

        return $result;
    }

    /**
     * Get collection of models.
     * @param array $filters
     * @param array $columns
     * @return Collection
     */
    public function get(
        array $filters = [], array $columns = ['*']
    ): Collection
    {
        $this->filter($filters);

        $result = $this->getQuery()->get($columns);

        $this->resetQuery();

        return $result;
    }

    /**
     * Create new instance in of model in database.
     * @param array $input
     * @return Model
     */
    public function create(
        array $input
    ): Model
    {
        $model = $this->model->newInstance($input);

        $model->saveOrFail();

        return $model;
    }

    /**
     * Update existing instance in database.
     * @param array $input
     * @param int $id
     * @param Model $model
     * @return Model
     */
    public function update(
        array $input, int $id, Model $model = null
    ): Model
    {
        if (!$model) {
            $model = $this->find($id);
        }

        $model->update($input);

        $this->resetQuery();

        return $model;
    }

    /**
     * Delete record in database.
     * @param int $id
     * @return boolean
     */
    public function delete(
        int $id
    ): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * Get count of queryable records.
     * @return integer
     */
    public function count(): int
    {
        $count = $this->getQuery()->count();

        $this->resetQuery();

        return $count;
    }

    /**
     * Set filter params to queryable,
     * @param array $filters
     * @return IRepository|$this
     * @throws \Exception
     */
    protected function filter(array $filters = []): IRepository
    {
        foreach ($filters as $index => $filter) {
            if (is_array($filter)) {
                $this->query = call_user_func_array(
                    [$this->getQuery(), 'where'], $filter
                );
            } else {
                $type = gettype($filter);
                throw new \Exception(
                    "Filters property should be array with arrays, but got" .
                    " '$type' at position '$index'"
                );
            }
        }

        return $this;
    }

    /**
     * Get actual query.
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        if (!$this->query) {
            $this->query = $this->model->newQuery();
        }

        return $this->query;
    }

    /**
     * Reset current query to new instance.
     */
    protected function resetQuery()
    {
        $this->query = $this->model->newQuery();
    }
}