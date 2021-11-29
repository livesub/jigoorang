<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review_saves extends Model
{
    use HasFactory;

    protected $fillable = [
        'exp_id',
        'exp_app_id',
        'sca_id',
        'cart_id',
        'item_code',
        'user_id',
        'user_name',
        'score1',
        'score2',
        'score3',
        'score4',
        'score5',
        'average',
        'review_content',
        'review_img1',
        'review_img_name1',
        'review_img2',
        'review_img_name2',
        'review_img3',
        'review_img_name3',
        'review_img4',
        'review_img_name4',
        'review_img5',
        'review_img_name5',
        'temporary_yn',
        'review_blind',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
