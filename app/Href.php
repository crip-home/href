<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'date_added' => 'datetime',
        'parent_id' => 'integer',
        'user_id' => 'integer',
        'visible' => 'boolean',
    ];

    /**
     * Many to one relation with users table.
     */
    public function user() 
    {
        return $this->belongsTo(
            User::class, 'user_id', 'id'
        );
    }

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

    /**
     * One to many inverse relation with categories table.
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}