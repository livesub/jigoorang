<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; //비밀번호 함수
use Illuminate\Support\Facades\Auth;    //인증
use App\Http\Controllers\statistics\StatisticsController;        //통계 호출

class socialLoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirect($provider, Request $request)
    {
/*
        $parameters = ['access_type' => 'offline', "prompt" => "consent select_account"];
        return Socialite::driver('kakao')
            ->scopes(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/forms'])
            ->with($parameters)// refresh token
            ->redirect();

        return Socialite::driver($provider)->redirect();
*/

        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        if($request->get('error') != "access_denied" || $request->get('error') != "invalid_grant"){

            $social_info = Socialite::driver($provider)->user();

            $user_info = User::whereUser_id($social_info->email)->first();

            $user_pw = pack('V*', rand(), rand(), rand(), rand()); //비밀번호 강제 생성

            if(empty($user_info)){
                //네이버 와 카카오톡 관련 분기점이 필요
                $user_gender = "";  //성별
                $user_birth = "";   //생년월일
                $user_phone = "";   //핸드폰번호

                if($provider == "kakao"){
                    dd($social_info->user['kakao_account']);
                    $user_kakao = $social_info->user['kakao_account'];
                    if($user_kakao['gender'] == 'male'){
                        $user_gender = 'M';
                    }else{
                        $user_gender = 'W';
                    }
                    

                }else if($provider == "naver"){
                    //dd($social_info->user['response']);
                    $user_naver = $social_info->user['response'];
                    $user_gender = $user_naver['gender'];
                    $user_phone = str_replace("-", "", $user_naver['mobile']);
                    $user_birth = $user_naver['birthyear'].str_replace("-", "", $user_naver['birthday']);
                    //dd($user_birth);
                }

                $create_result = User::create([
                    'user_id'               => $social_info->email,
                    'user_name'             => $social_info->name,
                    'user_activated'        => 1,
                    'user_level'            => 10,
                    'user_type'             => 'N',
                    'user_platform_type'    => $provider,
                    'password'              => Hash::make($user_pw),
                    'user_phone'            => $user_phone,
                    'user_gender'           => $user_gender,
                    'user_birth'            => $user_birth,
                ]);

                Auth::login($create_result, $remember = true);

                //회원 로그인 통계처리
                $statistics = new StatisticsController();
                $statistics->mem_statistics($social_info->email);

                return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
            }else{
                if($user_info->user_type == 'Y'){
                    auth()->logout();
                    return redirect()->route('main.index')->with('alert_messages', $Messages::$social['withdraw_chk']);

                }else{
                    Auth::login($user_info, $remember = true);

                    //회원 로그인 통계처리
                    $statistics = new StatisticsController();
                    $statistics->mem_statistics($social_info->email);

                    return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
                }
            }
        }else{
            //인증 취소시
            return redirect()->route('main.index')->with('alert_messages', $Messages::$social['join_cencel']);
        }
    }
}
