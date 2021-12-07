<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\findIdPwService;
use App\Http\Requests\ChangePwRequest;
use App\Models\ShortLink;

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

        //비밀번호 재설정 링크 문자로 전송

        return response()->json(array($result),200,[],JSON_UNESCAPED_UNICODE);
    }

    //비밀번호 변경에 관련
    public function update_pw_service(ChangePwRequest $request){

        $result = $this->findIdPwService->update_pw($request);

        if($result == true){

            return redirect()->route('main.index')->with('alert_messages', __('auth.success_change_pw'));

        }else{

            return redirect()->route('main.index')->with('alert_messages', __('auth.failed_change_pw'));

        }
    }

    //비밀번호 변경 단축 URL 관련
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        if(!empty($find)){

            return redirect($find->link);

        }else{

            $this->findIdPwService->delete_short_url_time_out();

            return redirect()->route('main.index')->with('alert_messages', __('auth.failed_to_limit_time'));
        }

    }

    //단축 url 삭제관련
    public function delete_short_url(){

        $this->findIdPwService->delete_short_url_time_out();

        //return redirect()->route('main.index')->with('alert_messages', __('auth.failed_to_limit_time'));
        return view('auth.failed_time_limit');
    }

    //제한시간이 지난 경우의 페이지 이동 관련
    public function move_time_limit_page(){

        return view('auth.failed_time_limit');
    }
}
