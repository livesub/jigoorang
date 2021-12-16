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
        'temporary_yn',
        'review_blind',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
