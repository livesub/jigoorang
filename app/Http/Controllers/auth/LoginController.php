<?php
#############################################################################
#
#		파일이름		:		LoginController.php
#		파일설명		:		로그인
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;  //체크
use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\Auth;    //인증
use App\Http\Controllers\statistics\StatisticsController;        //통계 호출
//request
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //로그인 된 상태에선 이페이지 못열게
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $url  = $request->input('url');

        return view('auth.login',[
            'url'   => $url,
        ],$Messages::$blade_ment['login']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**************************************************************************/
     /* $user_pw 을 사용 하면 로그인이 되지 않으므로 칼럼명을 password 로 바꾼다 */
     /**************************************************************************/
    public function store(LoginRequest $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_id    = $request->get('user_id');
        $user_pw    = $request->get('user_pw');
        $remember   = $request->has('remember');
        $url        = $request->input('url'); //쇼핑몰 등 리턴 페이지가 있을때
        $id_remember = $request->id_remember;

        // Validator::validate($request->all(), [
        //     'user_id'  => ['required', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200'],
        //     'user_pw'  => ['required', 'string', 'min:6', 'max:16'],
        // ], $Messages::$login_Validator['login_Validator']);

        //아이디 기억하기가 있을 경우 세션에 저장 아닐경우 삭제
        if($id_remember == "1"){

            setcookie('id_remember', $user_id, time() + (86400*7));

        }else{
            setcookie("id_remember", "", time() - 3600);

        }

        $credentials = [
            'user_id' => trim($user_id),
            'password' => $user_pw,
            'user_type' => 'N',
        ];

        if (!Auth::attempt($credentials, $remember))
        {
            if (preg_match("/orderform/", $url)){   //장바구니로 왔는데 로그인 실패시 계속 로그인 페이지에 남기
                return redirect()->route('login.index','url='.urlencode(route('orderform')))->with('alert_messages', $Messages::$login_chk['login_chk']['login_chk']);
            }else{
                return redirect()->route('login.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_chk']);
            }
            exit;
        }

        //사이트 접근 불가 회원일때 로그 아웃 시킴 (220103)
        if(Auth::user()->site_access_no == 'y'){
            auth()->logout();
            return redirect()->route('main.index')->with('alert_messages', '사이트 접근 불가 회원입니다.');
        }



        //이메일 인증이 안됬으면 로그아웃 시킴
        // if(!auth()->user()->user_activated)
        // {
        //     auth()->logout();
        //     if (preg_match("/orderform/", $url)){   //장바구니로 왔는데 로그인 실패시 계속 로그인 페이지에 남기
        //         return redirect()->route('login.index','url='.urlencode(route('orderform')))->with('alert_messages', $Messages::$login_chk['login_chk']['email_chk']);
        //     }else{
        //         return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['email_chk']);
        //     }
        //     exit;
        // }

        //회원 로그인 통계처리
        //$statistics = new StatisticsController();
        //$statistics->mem_statistics($user_id);

        if (preg_match("/orderform/", $url)){   //장바구니로 리턴
            return redirect()->route('orderform')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
        }else{
            return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['login_ok']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        auth()->logout();
        return redirect()->route('main.index')->with('alert_messages', $Messages::$logout_chk['logout']['logout']);
        exit;
    }
}
