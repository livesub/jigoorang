<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qnas extends Model
{
    use HasFactory;

    protected $fillable = [
        'qna_cate',
        'qna_subject',
        'order_id',
        'user_id',
        'user_name',
        'qna_content',
        'qna_answer',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
