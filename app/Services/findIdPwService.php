<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use App\Services\smsService;
use App\Models\ShortLink;
use Illuminate\Support\Str;
//시간 관련 사용
use \Carbon\Carbon;
/**
 * Class findIdPwService
 * @package App\Services
 */
class findIdPwService
{

    //service 클래스에 위임하기 위해 생성자에서 선언
    public function __construct(smsService $smsService)
    {
        $this->smsService = $smsService;
        
    }

    
    public function findID($user_phone){
        
        $user_info = User::whereUser_phone($user_phone)->first();

        if(!empty($user_info) && $user_info->user_platform_type == ""){
            
            //보낼 메세지 설정
            $message = "고객님의 지구랭 아이디는".$user_info->user_id."입니다.";
            //여기서 문자로 보낸다.
            $result = $this->smsService->send_sms_custom($message, $user_phone);

            //return $user_info->user_id;
            return $result;

        }else if(!empty($user_info) && $user_info->user_platform_type != ""){

            return $user_info->user_platform_type;

        }else{

            return null;
        }
    }

    public function send_pw_link($user_phone){

        $user_info = User::whereUser_phone($user_phone)->first();

        if(!empty($user_info) && $user_info->user_platform_type == ""){
            
            $input['code'] = Str::random(6);
            $url = URL::temporarySignedRoute('sendPwChangeLinkPro', now()->addMinutes(2), ['code' => Crypt::encryptString($user_info->id)]);
            //return URL::temporarySignedRoute('sendPwChangeLinkPro', now()->addMinutes(2), ['code' => Crypt::encryptString($user_info->id)]);
            //$result = $this->rand_code_save($url);

            $input['link'] = $url;
            ;
            $result = ShortLink::create($input)->exists();

            if($result){
                //문자 보내기
                $message = "아래 링크를 통해 변경하신 후 이용 가능합니다.\n".route('short_url', $input['code']);
                $result2 = $this->smsService->send_sms_custom($message, $user_phone);
                return $result2;
            }else{
                return "";
            }
            

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

            $url_code = $data->url_code;
            $short = ShortLink::where('link', $url_code);
            $short->delete();

            return true;
        } catch (DecryptException $e) {
            //

            return $e;
        }
        
    }

    //단축 url 관련 삭제 함수
    public function delete_short_url_time_out(){
        //생성시간이 5분전 보다 작을 경우(즉 5분이 지난 링크들)
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subMinutes(2);

        $results = ShortLink::where('created_at', '<', $newDateTime);
        
        $results->delete();
    }
    
}
