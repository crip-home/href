<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Href
 * @package App
 */
class Href extends Model
{
    use Audit;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'hrefs';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'parent_id', 'user_id', 'date_added', 'index', 'visible', 'title',
        'url',
    ];

    /**
     * Many to many relation with tags table.
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, 'href_tags', 'href_id', 'tag_id'
        );
    }
}