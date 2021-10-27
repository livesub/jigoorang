<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\findIdPwService;
use App\Http\Requests\ChangePwRequest;

class findIdPwController extends Controller
{
    private $userService;
    //private $user;

    //service 클래스에 위임하기 위해 생성자에서 선언
    public function __construct(findIdPwService $findIdPwService)
    {
        $this->findIdPwService = $findIdPwService;
    }

    //아이디 및 비밀번호 찾기 view로 이동
    public function findIdPwView(){
        
        return view('auth.findIdPw');
    }

    //아이디 찾기 관련
    public function findId(Request $request){
        $user_phone = $request->user_phone;
        
        $result = $this->findIdPwService->findID($user_phone);

        //dd($result);

        return response()->json(array($result),200,[],JSON_UNESCAPED_UNICODE);
       
    }

    //비밀번호 재설정 링크 관련
    public function sendPwChangeLink(Request $request){
        
        $user_phone = $request->user_phone;

        $result = $this->findIdPwService->send_pw_link($user_phone);

        return response()->json(array($result),200,[],JSON_UNESCAPED_UNICODE);
    }

    //비밀번호 변경에 관련
    public function update_pw_service(ChangePwRequest $request){

        $result = $this->findIdPwService->update_pw($request);

        if($result == true){

            return redirect()->route('main.index')->with('alert_messages', __('auth.success_change_pw'));

        }else{

            return redirect()->route('main.index')->with('alert_messages', __('auth.success_change_pw'));
            
        }
    }
}
