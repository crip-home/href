<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App
 */
class Tag extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'tag'
    ];
}