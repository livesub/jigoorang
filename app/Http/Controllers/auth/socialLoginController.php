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

        //네이버 와 카카오톡 관련 분기점이 필요
        $user_gender = "";  //성별
        $user_birth = "";   //생년월일
        $user_phone = "";   //핸드폰번호

        if($request->get('error') != "access_denied" || $request->get('error') != "invalid_grant"){
            
            //$social_info = Socialite::driver($provider)->user();
            try {
                $social_info = Socialite::driver($provider)->user();

                if($provider == "kakao"){
                    //dd($social_info->user['kakao_account']);
                    $user_kakao = $social_info->user['kakao_account'];
                    if($user_kakao['gender'] == 'male'){
                        $user_gender = 'M';
                    }else{
                        $user_gender = 'W';
                    }
                    $user_birth = "1996".$user_kakao['birthday'];
                    $user_phone = "01074811229";
                    
    
                }else if($provider == "naver"){
                    //dd($social_info->user['response']);
                    $user_naver = $social_info->user['response'];
                    $user_gender = $user_naver['gender'];
                    $user_phone = str_replace("-", "", $user_naver['mobile']);
                    $user_birth = $user_naver['birthyear'].str_replace("-", "", $user_naver['birthday']);
                    //dd($user_birth);
                }
    
                
                //핸드폰 번호 기준으로 변경이 필요하다.
                //$user_info = User::whereUser_id($social_info->email)->first();
    
                $user_info = User::whereUser_phone($user_phone)->first();
    
                $user_pw = pack('V*', rand(), rand(), rand(), rand()); //비밀번호 강제 생성
    
                if(empty($user_info)){
    
                    //휴대폰 인증 추가 여부 확인 필요 view가 필요 데이터 바인딩 후에 넘겨주어야 할듯
                    $create_result = [
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
                    ];
    
                    return view('auth.social_sms', compact('create_result'));
                    
                    // $create_result = User::create([
                    //     'user_id'               => $social_info->email,
                    //     'user_name'             => $social_info->name,
                    //     'user_activated'        => 1,
                    //     'user_level'            => 10,
                    //     'user_type'             => 'N',
                    //     'user_platform_type'    => $provider,
                    //     'password'              => Hash::make($user_pw),
                    //     'user_phone'            => $user_phone,
                    //     'user_gender'           => $user_gender,
                    //     'user_birth'            => $user_birth,
                    // ]);
    
                    // Auth::login($create_result, $remember = true);
    
                    // //회원 로그인 통계처리
                    // $statistics = new StatisticsController();
                    // $statistics->mem_statistics($social_info->email);
    
                    // return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
                }else{
                    if($user_info->user_type == 'Y'){
                        auth()->logout();
                        return redirect()->route('main.index')->with('alert_messages', $Messages::$social['withdraw_chk']);
    
                    }else{
                        if($provider == $user_info->user_platform_type){
                            Auth::login($user_info, $remember = true);
    
                            //회원 로그인 통계처리
                            $statistics = new StatisticsController();
                            $statistics->mem_statistics($social_info->email);
    
                            return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
                        }else{
                            //번호는 같으나 서로 다른 플랫폼에서 로그인 될 경우 예외처리
                            //다국어 처리 resource/lang/en or kr(locale에 따른)/socialLogin/platform_cross에서 확인가능
                            return redirect()->route('main.index')->with('alert_messages', $provider.__('socialLogin.platform_cross'));
                        }
                        
                    }
                }
            } catch (\Exception $e) {
                //$social_info = Socialite::driver($provider)->stateless()->user();
                return redirect()->route('main.index')->with('alert_messages', __('auth.repeat_access'));
            }

            
        }else{
            //인증 취소시
            return redirect()->route('main.index')->with('alert_messages', $Messages::$social['join_cencel']);
        }
    }


    //소셜로그인 문자인증 완료 후에 값 저장 함수
    public function save_member(Request $request){

        $social_info = $request;

        $create_result = User::create([
            'user_id'               => $social_info->user_id,
            'user_name'             => $social_info->user_name,
            'user_activated'        => 1,
            'user_level'            => 10,
            'user_type'             => 'N',
            'user_platform_type'    => $social_info->user_provider,
            'password'              => Hash::make($social_info->password),
            'user_phone'            => $social_info->user_phone,
            'user_gender'           => $social_info->user_gender,
            'user_birth'            => $social_info->user_birth,
        ]);

        //가입 시 cookie 삭제
        if($_COOKIE["social_num"] != "" || $_COOKIE["social_cetification"] != ""){
            setcookie("social_num", "", 0, "/");
            setcookie("social_certification", "", 0, "/");
        }
        //추가 확인 필요 후 주석 제거 하면 정상 작동
        /** 가입 포인트 추가(211015) **/
        // $setting_info = CustomUtils::setting_infos();

        // $po_content = date('Y-m-d')." 회원 가입 축하";
        // $po_point = $setting_info->member_reg_point;    //지급 포인트 금액
        // $po_use_point = 0;  //사용금액
        // $po_type = 1;   //적립금 지급 유형 : 1=>회원가입,3=>구매평,5=>체험단평,7=>기타등등
        // $po_write_id = 0;   //적립금 지급 유형 글번호
        // $item_code = '';    //상품코드

        // $po_cnt = DB::table('shoppoints')->where([['user_id', $social_info->user_id],['po_type',1]])->count(); //신규 회원 가입시 이미 주어진 포인트가 있는지

        // if($setting_info->member_reg_point > 0 && $po_cnt == 0){
        //     CustomUtils::user_point_chk($social_info->user_id, $po_content, $po_point, $po_use_point, $po_type, $po_write_id, $item_code);
        // }
        /** 가입 포인트 추가(211015) 끝 **/

        Auth::login($create_result, $remember = true);

        //회원 로그인 통계처리
        $statistics = new StatisticsController();
        $statistics->mem_statistics($social_info->user_id);

        return redirect()->route('main.index')->with('alert_messages', __('auth.welcome'));
    }
}
