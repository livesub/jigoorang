<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppoints extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'po_content',
        'po_point',
        'po_use_point',
        'po_user_point',
        'po_type',
        'po_write_id',
        'item_code',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
