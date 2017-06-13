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

    /**
     * Filter query results to select records where user id is presented id
     * parameter.
     * @param int $id Te id of the user.
     * @return IHrefRepository
     */
    public function filterOwner(int $id): IHrefRepository;

    /**
     * Filter query results to select records where parent id is presented id
     * parameter.
     * @param int $parentId
     * @return IHrefRepository
     */
    public function filterWhereParent(int $parentId): IHrefRepository;
}