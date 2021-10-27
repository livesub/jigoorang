<?php

namespace App\Http\Controllers\sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\smsService;
use App\Services\userService;

class aligoSmsController extends Controller
{
    //service 클래스에 위임하기 위해 생성자에서 선언
    public function __construct(smsService $smsService, userService $userService)
    {
        $this->smsService = $smsService;
        $this->userService = $userService;
    }

    //인증문자를 보내기 위한 함수
    public function auth_certification(Request $request){
        
        $user_phone = $request->user_phone;

        //그 번호로 일단 등록된 유저가 있는지 확인해야한다.
        $exists = $this->userService->find_user_to_phone_number($user_phone);

        if(($user_phone != "" || $user_phone != null) && $exists == ""){

            $result = $this->smsService->auth_certification($user_phone);
            // return $user_phone;
        }else{
            $result = ['2'];

            return $result;
        }
        
        //dd($result);
        
        //return value 에서 result_code 가 1이 아닐경우에 문자전송 실패니 그에따른 분기점이 필요하다.

        return response()->json(array($result),200);
    }

    //테스트용 함수
    public function test_certification(){

        $result = $this->smsService->test_certification();

        //dd($result);

        //return $result;
        return response()->json(array($result),200);
    }

    //발송내역 테스트
    public function get_sms_list(){

        $result = $this->smsService->get_list_sms_form_id("273562886");

        dd($result);
        //dd($result->list[0]->msg);
    }
}
