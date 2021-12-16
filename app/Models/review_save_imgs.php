<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review_save_imgs extends Model
{
    use HasFactory;

    protected $fillable = [
        'rs_id',
        'review_img',
        'review_img_name',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
