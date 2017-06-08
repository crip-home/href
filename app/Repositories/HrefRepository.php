<?php namespace App\Repositories;

use App\Contracts\IHrefRepository;
use App\Href;
use Illuminate\Support\Collection;

/**
 * Class HrefRepository
 * @package App\Repositories
 */
class HrefRepository extends PaginateRepository implements IHrefRepository
{
    /**
     * Get current repository model full class name.
     * @return string
     */
    function modelClass(): string
    {
        return Href::class;
    }
}