<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash; //비밀번호 함수
/**
 * Class MemberService
 * @package App\Services
 */
class MemberService
{

    //비밀번호 변경 함수
    public function update_pw($request){

        $user = User::find(auth()->user()->id);

        $result = $user->update([
            'password' => Hash::make($request->user_pw),
        ]);

        return $result;
    }

    //핸드폰 번호 변경 함수
    public function update_phone_number($request){

        $user = User::find(auth()->user()->id);

        $result = $user->update([
            'user_phone' => $request->user_phone,
        ]);

        return $result;
    }

    //회원 선택동의 사항 변경 함수
    public function update_member($request){

        $user = User::find(auth()->user()->id);

        $agree = $request->select_agree;

        if($agree == "" || $agree == null){
            $agree = "N";
        }

        $result = $user->update([
            'user_promotion_agree' => $agree,
        ]);

        return $result;
    }
}
