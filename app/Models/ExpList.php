<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpList extends Model
{
    use HasFactory;

    protected $table = 'exp_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'main_image_name',
        'main_image_ori_name',
        'item_id',
        'item_name',
        'exp_date_start',
        'exp_date_end',
        'exp_review_start',
        'exp_review_end',
        'exp_release_date',
        'exp_content',
        'exp_limit_personnel',
    ];
}
