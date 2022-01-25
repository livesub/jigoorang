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
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
