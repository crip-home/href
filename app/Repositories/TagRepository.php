<?php namespace App\Repositories;

use App\Contracts\ITagRepository;
use App\Tag;
use DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagRepository
 * @package App\Repositories
 */
class TagRepository extends Repository implements ITagRepository
{

    /**
     * Get current repository model full class name.
     * @return string
     */
    function modelClass(): string
    {
        return Tag::class;
    }

    /**
     * Join tags usage count column to the query results.
     * @return Builder
     */
    public function joinHrefUsageCount(): Builder
    {
        $query = '(
            SELECT `pivot`.`tag_id`, COUNT(`pivot`.`tag_id`) AS `tag_count` 
              FROM `href_tags` as `pivot`
              LEFT JOIN `hrefs` as `h` ON `h`.`id` = `pivot`.`tag_id`
             WHERE `h`.`visible` = 1
             GROUP BY `tag_id`) AS `tc`';

        return $this->getQuery()->join(
            DB::raw($query), 'tags.id', '=', 'tc.tag_id'
        );
    }
}