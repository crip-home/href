<?php namespace App\Contracts;

/**
 * Interface IHrefRepository
 * @package App\Contracts
 */
interface IHrefRepository extends IPaginateRepository
{
    /**
     * Join users, tags and categories to query results.
     * @return IHrefRepository
     */
    public function withUsersTagsAndCategories(): IHrefRepository;

    /**
     * Filter query results by related table ids arrays.
     * @param array $authors
     * @param array $categories
     * @param array $tags
     * @return IHrefRepository
     */
    public function filterByRelated(
        array $authors, array $categories, array $tags
    ): IHrefRepository;

    /**
     * Filter query results to select only visible records and order them by
     * date added field.
     * @return IHrefRepository
     */
    public function onlyVisibleAndOrderedByDate(): IHrefRepository;
}