<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
/**
 * Class findIdPwService
 * @package App\Services
 */
class findIdPwService
{
    public function findID($user_phone){
        
        $user_info = User::whereUser_phone($user_phone)->first();

        if(!empty($user_info) && $user_info->user_platform_type == ""){
            
            return $user_info->user_id;

        }else if(!empty($user_info) && $user_info->user_platform_type != ""){

            return $user_info->user_platform_type;

        }else{

            return null;
        }
    }

    public function send_pw_link($user_phone){

        $user_info = User::whereUser_phone($user_phone)->first();

        if(!empty($user_info) && $user_info->user_platform_type == ""){
            
            return URL::temporarySignedRoute('sendPwChangeLinkPro', now()->addMinutes(2), ['code' => Crypt::encryptString($user_info->id)]);

        }else if(!empty($user_info) && $user_info->user_platform_type != ""){

            return $user_info->user_platform_type;
            
        }else{

            return null;
        }
    }

    public function update_pw($data){
        $user_phone = "";
        try {
            //복호화 후 복호화한 것으로 user를 찾는다.
            $user_id = Crypt::decryptString($data->code);
            $user = User::find($user_id);

            $update_result = $user->update([
                'password' => Hash::make($data->user_pw),
            ]);

            return true;
        } catch (DecryptException $e) {
            //

            return $e;
        }
        
    }
}
