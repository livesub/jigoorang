<?php

namespace App\Services;
use App\Models\User;    //모델 정의
/**
 * Class userService
 * @package App\Services
 */
class userService
{   
    //번호를 이용 해당 번호를 가진 유저를 조회 
    public function find_user_to_phone_number($user_phone){

        $user_info = User::whereUser_phone($user_phone)->first();

        if(!empty($user_info)){

            return $user_info;
        }else{

            return "";
        }
    }
}
