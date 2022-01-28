<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpApplicationList extends Model
{
    use HasFactory;

    protected $table = 'exp_application_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'exp_id',
        'item_id',
        'sca_id',
        'ad_name',
        'ad_hp',
        'ad_zip1',
        'ad_addr1',
        'ad_addr2',
        'ad_addr3',
        'ad_jibeon',
        'shipping_memo',
        'reason_memo',
        'access_yn',
        'write_yn',
        'promotion_yn',
        'user_name',
    ];
}
