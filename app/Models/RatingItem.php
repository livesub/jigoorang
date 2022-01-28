<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingItem extends Model
{
    use HasFactory;

    protected $table = 'rating_item';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sca_id',
        'item_name1',
        'item_name2',
        'item_name3',
        'item_name4',
        'item_name5',
    ];
}
