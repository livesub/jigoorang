<?php
#############################################################################
#
#		파일이름		:		JoinController.php
#		파일설명		:		회원가입
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
use Illuminate\Support\Facades\Hash; //비밀번호 함수
use Illuminate\Support\Str;     //각종 함수(str_random)
use Illuminate\Support\Facades\Mail;    //메일 class
use Illuminate\Support\Facades\DB;
use App\Models\shoppoints;    //포인트 모델 정의
//Request class 적용 request값의 예외처리에 대한 정의
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;    //인증



class JoinController extends Controller
{
    public function __construct(User $user)
    {
        //로그인 된 상태에선 이 페이지 못열게
        $this->middleware('guest', ['except' => 'destroy']);
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $agree)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $url = $request->input('url');

        return view('auth.join',[
            'url'   => $url,
            'agree' => $agree,
        ],$Messages::$blade_ment['join']);
    }

    public function index_agree_view(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $url = $request->input('url');

        return view('auth.join_agree',[
            'url'   => $url,
        ],$Messages::$blade_ment['join']);
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

     //vaildator를 App\Http\Requests\UserRequest 에 위임
     public function store(UserRequest $request)
    {
        //dd($request);
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $url = trim($request->get('url'));

        $user_id = trim($request->get('user_id'));
        $user_name = trim($request->get('user_name'));
        $user_pw = trim($request->get('user_pw'));
        //$user_pw_confirmation = trim($request->get('user_pw_confirmation'));
        //$user_email = $request->get('user_email');
        $user_phone = trim($request->get('user_phone'));
        $user_gender = trim($request->user_gender);
        $user_birth = trim(str_replace("-", "", $request->user_birth));
        //$user_confirm_code = str::random(60);  //사용자 이메일 확인을 위해서..
        $promotion_agree = trim($request->promotion_agree);

        //trans('messages.join_Validator')) class 컨트롤러에서 표현 할때
        //예외처리
        // Validator::validate($request->all(), [
        //     'user_id'  => ['required', 'string', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200', 'unique:users'],
        //     'user_name'  => ['required', 'string'],
        //     'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
        //     'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
        //     'user_phone'  => ['required', 'max:20']
        // ], $Messages::$validate['join']);

/******************************************************* */
/* model 형식으로 DB 처리 프로그램 할때 사용               */
/******************************************************* */
        //같은 아이디가 있는지 파악(validator user_id 에서 unique:users 하기에 같은 아이디 찾기 프로그램은 필요 없다.)
        /*
        $count_result = User::where('user_id', '=', $user_id) -> count();
        if($count_result <> 0) {
            return response()->json(['status' => 'overlap_user_id'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
        */

        //User::insert 일때는 created_at,updated_at 값이 자동으로 들어 가지 않는다.
        $create_result = User::create([
            'user_id' => $user_id,
            'user_name' => $user_name,
            'password' => Hash::make($user_pw),
            'user_activated' => 1,
            'user_phone' => $user_phone,
            'user_gender' => $user_gender,
            'user_birth' => $user_birth,
            'user_promotion_agree' => $promotion_agree,
        ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀
        //'user_confirm_code' => $user_confirm_code,

        //가입 시 cookie 삭제
        // if($_COOKIE[$request->cookie1] != "" || $_COOKIE[$request->cookie2] != ""){
        //     setcookie($request->cookie1, "", 0, "/");
        //     setcookie($request->cookie2, "", 0, "/");
        // }
        /** 가입 포인트 추가(211015) **/
        $setting_info = CustomUtils::setting_infos();

        $po_content = "회원 가입 적립";
        $po_point = $setting_info->member_reg_point;    //지급 포인트 금액
        $po_use_point = 0;  //사용금액
        $po_type = 1;   //적립금 지급 유형 : 1=>회원가입,3=>구매평,5=>체험단평,7=>상품구입
        $po_write_id = 0;   //적립금 지급 유형 글번호
        $order_id = '';    //상품코드

        $po_cnt = DB::table('shoppoints')->where([['user_id', $user_id],['po_type',1]])->count(); //신규 회원 가입시 이미 주어진 포인트가 있는지

        if($setting_info->member_reg_point > 0 && $po_cnt == 0){
            CustomUtils::user_point_chk($user_id, $po_content, $po_point, $po_use_point, $po_type, $po_write_id, $order_id);
        }
        /** 가입 포인트 추가(211015) 끝 **/


        if($create_result){
            //가입 즉시 로그인으로 변경(211223)
            $credentials = [
                'user_id' => trim($user_id),
                'password' => $user_pw,
                'user_type' => 'N',
            ];

            Auth::attempt($credentials, $remember=true);
            return redirect()->route('main.index')->with('alert_messages', $Messages::$join_confirm_ment['confirm']['join_success']);
        }else{
            return redirect()->route('main.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
        }

/*
        if($create_result) return redirect()->route('main.index')->with('alert_messages', $Messages::$join_confirm_ment['confirm']['join_success']);
        else return redirect()->route('main.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
*/
    }

    /* 인증 메일을 통한 인증 작업 */
    public function confirm($code)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user = User::whereUserConfirmCode($code)->first();

        if (!$user) {
            return redirect()->route('join.create')->with('alert_messages', $Messages::$email_certificate['email_certificate']['email_confirm_fail']);
            exit;
        }

        $user->user_activated = 1;
        $user->user_confirm_code = null;
        $user->save();

        return redirect()->route('join.create')->with('alert_messages', $Messages::$email_certificate['email_certificate']['email_confirm_success']);
        exit;
    }

    //이메일 중복체크 관련 함수
    public function email_certification(Request $request){
        //dd($email);
        $result = $this->user->get_email_check($request->user_id);


        if($result == "" || $result == null || empty($result)){
            //비어있을 경우 true
            $result = "true";
            return response()->json(array($result),200);
            //return true;
        }else{
            //중복일 경우 false
            $result = "false";
            return response()->json(array($result),200);
            //return false;
        }

        //return response()->json(array($result),200);
        //return $result;
    }

    //이메일 중복체크 관련 함수 test
    // public function email_certification_test($email){
    //     //dd($email);
    //     $result = $this->user->get_email_check($email);

    //     if($result == "" || $result == null || empty($result)){
    //         //비어있을 경우 true
    //         $result = "true";
    //         return response()->json(array($result),200);
    //     }else{
    //         //중복일 경우 false
    //         $result = "false";
    //         return response()->json(array($result),200);
    //     }
    //     //return response()->json(array($result),200);
    //     //return $result;
    // }
}
