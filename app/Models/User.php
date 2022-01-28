<?php
#############################################################################
#
#		파일이름		:		User.php
#		파일설명		:		회원 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'password',
        'user_tel',
        'user_birth',
        'user_gender',
        'user_promotion_agree',
        'user_phone',
        'user_birth',
        'user_gender',
        'user_imagepath',
        'user_ori_imagepath',
        'user_thumb_name',
        'user_confirm_code',
        'user_activated',
        'user_level',
        'user_type',
        'user_platform_type',
        'user_zip',
        'user_addr1',
        'user_addr2',
        'user_addr3',
        'user_addr_jibeon',
        'user_point',
        'withdraw_type',
        'withdraw_content',
        'blacklist',
        'site_access_no',
        'withdraw_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_confirm_code',
        'user_level',
        'user_phone',
        'user_type',
        'user_platform_type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_activated' => 'boolean'
    ];

    //해당 이메일을 가진 user의 정보를 리턴
    public function get_email_check($user_id){

        //$user_info = $this->where('user_id', '=' ,$user_id)->get();
        $user_info = $this->whereUser_id($user_id)->first();

        return $user_info;
    }
}
