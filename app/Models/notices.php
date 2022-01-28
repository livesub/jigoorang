<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notices extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_subject',
        'n_explain',
        'n_img',
        'n_img_name',
        'n_content',
        'n_view_cnt',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
