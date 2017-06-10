<?php namespace App\Repositories;

use App\Contracts\IHrefRepository;
use App\Href;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
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

    /**
     * Join users, tags and categories to query results.
     * @return IHrefRepository
     */
    public function withUsersTagsAndCategories(): IHrefRepository
    {
        $this->query = $this->getQuery()->with([
            'creator' => function (BelongsTo $query) {
                $query->select(['id', 'name']);
            },
            'tags' => function (BelongsToMany $query) {
                $query->select(['tags.id', 'tags.tag']);
            },
            'category' => function (BelongsTo $query) {
                $query->select(['id', 'title']);
            }
        ]);

        return $this;
    }

    /**
     * Filter query results by ids arrays.
     * @param array $authors
     * @param array $categories
     * @param array $tags
     * @return IHrefRepository
     */
    public function filterByRelated(
        array $authors, array $categories, array $tags
    ): IHrefRepository
    {
        if (count($authors)) {
            $this->query = $this->getQuery()
                ->whereIn('created_by', $authors);
        }

        if (count($categories)) {
            $this->query = $this->getQuery()
                ->whereIn('category_id', $categories);
        }

        if (count($tags)) {
            $this->query = $this->getQuery()
                ->whereIn('id', function (BelongsToMany $query) use ($tags) {
                    $query->from('href_tags AS pivot')
                        ->join('tags AS t', 't.id', '=', 'pivot.tag_id')
                        ->whereIn('t.id', $tags)
                        ->select('pivot.href_id');
                });
        }

        return $this;
    }

    /**
     * Filter query results to select only visible records and order them by
     * date added field.
     * @return IHrefRepository
     */
    public function onlyVisibleAndOrderedByDate(): IHrefRepository
    {
        $this->query = $this->getQuery()
            ->where('url', '<>', '')
            ->where('visible', true)
            ->orderBy('date_added', 'desc');

        return $this;
    }
}