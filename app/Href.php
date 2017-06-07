<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Href
 * @package App
 */
class Href extends Model
{
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
}