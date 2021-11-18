<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Http\Requests\ChangePwRequest;

class MyPageInfoController extends Controller
{
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }
    //회원정보 수정 view 반환
    public function index(){

        return view('member.mypage_modi');
    }

    //비밀번호 변경 함수 서비스에 위임
    public function update_pw(ChangePwRequest $requset){

        $result = $this->memberService->update_pw($requset);

        return response()->json(array($result),200,[],JSON_UNESCAPED_UNICODE);
    }

    //핸드폰번호 변경 함수 서비스에 위임
    public function update_phone_number(Request $requset){

        $result = $this->memberService->update_phone_number($requset);

        return response()->json(array($result),200,[],JSON_UNESCAPED_UNICODE);

    }

    //회원정보수정 선택동의사항 변경 함수 서비스에 위임
    public function update_member(Request $request){

        $result = $this->memberService->update_member($request);

        if($result){
            return redirect()->route('mypage.index')->with('alert_messages', '수정이 완료되었습니다.');
        }else{
            return redirect()->route('member_info_index')->with('alert_messages', '다시 시도해주세요');
        }
    }
}
