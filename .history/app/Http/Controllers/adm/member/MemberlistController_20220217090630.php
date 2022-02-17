<?php
#############################################################################
#
#		파일이름		:		MemberlistController.php
#		파일설명		:		관리자페이지 - 회원 리스트,수정,삭제,비번 수정
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Http\Controllers\adm\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Models\User;    //모델 정의
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;     //각종 함수(str_random)
use Validator;  //체크
use Illuminate\Support\Facades\Hash; //비밀번호 함수
use Illuminate\Support\Facades\File;
use App\Helpers\Custom\PageSet; //페이지 함수

class MemberlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page       = $request->input('page');
        $user_type  = $request->input('user_type');
        $user_type2 = $request->input('user_type2');
        $keyword    = $request->input('keyword');

        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $members = DB::table('users')->where('user_level','>','2');

        if($user_type != ""){
            if($user_type == 'Y' || $user_type == 'N'){
                $members->where('user_type', $user_type);
            }else if($user_type == 'blacklist'){
                $members->where('blacklist', 'y');
            }else if($user_type == 'site_no'){
                $members->where('site_access_no', 'y');
            }

        }

        if($user_type2 != "" && $keyword != ""){
            $members->where($user_type2, 'like', '%'.$keyword.'%');
        }

        $member_draw = DB::table('users')->where([['user_level','>','2'], ['user_type', 'Y']])->count();    //탈퇴 회원
        $member_blacklist = DB::table('users')->where([['user_level','>','2'], ['blacklist', 'y']])->count();    //블랙리스트 회원
        $member_site_access_no = DB::table('users')->where([['user_level','>','2'], ['site_access_no', 'y']])->count();    //사이트 접근 불가 회원

        $total_record   = 0;
        $total_record   = $members->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $member_rows = $members->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['user_type'] = $user_type;
        $tailarr['user_type2'] = $user_type2;
        $tailarr['keyword'] = $keyword;

        $PageSet        = new PageSet;
        $showPage       = $PageSet->pageSet($total_page, $page, $pageScale, $blockScale, $total_record, $tailarr,"");
        $prevPage       = $PageSet->getPrevPage("이전");
        $nextPage       = $PageSet->getNextPage("다음");
        $pre10Page      = $PageSet->pre10("이전10");
        $next10Page     = $PageSet->next10("다음10");
        $preFirstPage   = $PageSet->preFirst("처음");
        $nextLastPage   = $PageSet->nextLast("마지막");
        $listPage       = $PageSet->getPageList();
        $pnPage         = $prevPage.$listPage.$nextPage;

        return view('adm.member.memberlist', [
            'user_type_selected'     => $user_type,
            'virtual_num'   => $virtual_num,
            'totalCount'    => $total_record,
            'members'       => $member_rows,
            'member_draw'   => $member_draw,
            'member_blacklist'   => $member_blacklist,
            'member_site_access_no'   => $member_site_access_no,
            'pageNum'       => $page,
            'pnPage'        => $pnPage,
            'user_type'     => $user_type,
            'user_type2'    => $user_type2,
            'keyword'       => $keyword,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mode       = $request->input('mode');
        $num        = $request->input('num');
        $user_gender = $request->input('user_gender');
        $user_birth = $request->input('user_birth');

        if($mode == "regi"){
            //등록일때
            $user_id = trim($request->get('user_id'));
            $user_name = trim($request->get('user_name'));
            $user_pw = trim($request->get('user_pw'));
            $user_pw_confirmation = trim($request->get('user_pw_confirmation'));
            //$user_email = $request->get('user_email');
            $user_phone = trim($request->get('user_phone'));
            $user_confirm_code = str::random(60);  //사용자 이메일 확인을 위해서..

            //trans('messages.join_Validator')) class 컨트롤러에서 표현 할때
            //예외처리
            Validator::validate($request->all(), [
                'user_id'  => ['required', 'string', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200', 'unique:users'],
                'user_name'  => ['required', 'string'],
                'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
                'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
                'user_phone'  => ['required', 'max:11', 'unique:users'],
                'user_birth'  => ['required', 'max:6'],
            ], $Messages::$validate['join']);

            if($request->hasFile('user_imagepath'))
            {
                //첨부 파일이 있을때
                $user_imagepath = $request->file('user_imagepath');
                foreach ($user_imagepath as $key => $file)
                {
                    //예외처리
                    Validator::validate($request->all(), [
                        'user_imagepath.*'  => ['max:10240', 'mimes:jpeg,jpg,gif']
                    ], $Messages::$file_chk['file_chk']);

                    $path = 'data/member';     //이미지 저장 경로
                    $attachment_result = CustomUtils::attachment_save($file,$path);

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('adm.member.show')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                        exit;
                    }else{
                        //서버에 올라간 파일을 썸네일 만든다.
                        $thumb_width = config('app.thumb_width');
                        $thumb_height = config('app.thumb_height');
                        $is_create = false;
                        $thumb_name = CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }
                }
            }else{
                //이미지 없을때 처리
                $attachment_result[1] = '';
                $attachment_result[2] = '';
                $thumb_name = '';
            }

            //User::insert 일때는 created_at,updated_at 값이 자동으로 들어 가지 않는다.
            $create_result = User::create([
                'user_id' => $user_id,
                'user_name' => $user_name,
                'password' => Hash::make($user_pw),
                'user_phone' => $user_phone,
                'user_confirm_code' => $user_confirm_code,
                'user_imagepath' => $attachment_result[1],
                'user_ori_imagepath' => $attachment_result[2],
                'user_thumb_name' => $thumb_name,
                'user_gender' => $user_gender,
                'user_birth' => $user_birth,
            ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀

            $data = array(
                'user_name' => $user_name,
                'user_confirm_code' => $user_confirm_code,
                'name_welcome' => $Messages::$email_certificate['email_certificate']['name_welcome'],
                'join_open' => $Messages::$email_certificate['email_certificate']['join_open'],
            );

            $subject = sprintf('[%s] '.$Messages::$join_confirm_ment['confirm']['join_confirm'], $user_name);
/*
            //이메일 함수 이용 발송
            $email_send_value = CustomUtils::email_send("auth.confirm_email",$user_name, $user_id, $subject, $data);

            if(!$email_send_value)
            {
                //이메일 발송 실패 시에 뭘 할건지 나중에 생각해야함
            }
*/
            if($create_result) return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$join_confirm_ment['confirm']['adm_join_success']);
            else return redirect()->route('adm.member.create')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
        }else{
            //수정일때
            Validator::validate($request->all(), [
                'user_name'  => ['required', 'string']
            ], $Messages::$validate['join']);

            $user_info = DB::table('users')->select('user_id', 'user_imagepath', 'user_thumb_name')->where('id', $num)->first();

            $user_name = trim($request->get('user_name'));
            $user_phone = trim($request->get('user_phone'));
            $user_level = $request->get('user_level');
            $user_type = $request->get('user_type');
dd($user_type);
            $user_id = $user_info->user_id;

            $blacklist = $request->get('blacklist');
            if($blacklist == "" ) $blacklist = 'n';
            $site_access_no = $request->get('site_access_no');
            if($site_access_no == "" ) $site_access_no = 'n';

            if($request->hasFile('user_imagepath'))
            {
                //첨부 파일이 있을때
                $user_imagepath = $request->file('user_imagepath');

                foreach ($user_imagepath as $key => $file)
                {
                    //예외처리
                    Validator::validate($request->all(), [
                        'user_imagepath.*'  => ['max:10240', 'mimes:jpeg,jpg,gif']
                    ], $Messages::$file_chk['file_chk']);

                    $path = 'data/member';     //이미지 저장 경로
                    $attachment_result = CustomUtils::attachment_save($file,$path);

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                        exit;
                    }else{
                        //서버에 올라간 파일을 썸네일 만든다.
                        $thumb_width = config('app.thumb_width');
                        $thumb_height = config('app.thumb_height');
                        $is_create = false;
                        $thumb_name = CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                    $user->user_name = $user_name;
                    $user->user_phone = $user_phone;
                    $user->user_level = $user_level;
                    $user->user_imagepath = $attachment_result[1];
                    $user->user_ori_imagepath = $attachment_result[2];
                    $user->user_thumb_name = $thumb_name;
                    $user->user_gender = $user_gender;
                    $user->user_birth = $user_birth;
                    $user->blacklist = $blacklist;
                    $user->site_access_no = $site_access_no;
                    $result_up = $user->save();

                    if(!$result_up)
                    {
                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
                        exit;
                    }else{

                        //기존 이미지가 있는지 체크
                        if($user_info->user_imagepath != "")
                        {
                            //기존에 이미 이미지가 있는 상태임
                            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_imagepath));
                        }

                        //기존 썸네일 이미지가 있는지 체크
                        if($user_info->user_thumb_name != "")
                        {
                            //기존에 이미 썸네일 이미지가 있는 상태임
                            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_thumb_name));
                        }

                        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$mypage['mypage']['my_change']);
                        exit;
                    }
                }
            }else{
                //첨부가 없을때
                $user = User::whereUser_id($user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
                $user->user_name = $user_name;
                $user->user_phone = $user_phone;
                $user->user_level = $user_level;
                $user->user_gender = $user_gender;
                $user->user_birth = $user_birth;
                $user->blacklist = $blacklist;
                $user->site_access_no = $site_access_no;
                $result_up = $user->save();

                if(!$result_up)
                {
                    return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
                    exit;
                }else{
                    return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$mypage['mypage']['my_change']);
                    exit;
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mode       = $request->input('mode');
        $num        = $request->input('num');
        $user_point = 0;

        if($mode == "regi"){
            //등록
            $select_disp = CustomUtils::select_box("user_level","회원@@관리자","10@@3", "");

            return view('adm.member.memberregi',[
                'title_ment'            => '등록',
                'mode'                  => 'regi',
                'num'                   => $num,
                'user_id'               => '',
                'user_name'             => '',
                'user_pw'               => '',
                'user_pw_confirmation'  => '',
                'user_phone'            => '',
                'user_imagepath'        => '',
                'select_disp'           => $select_disp,
                'user_point'            => $user_point,
                'user_gender'           => '',
                'user_birth'            => '',
                'user_platform_type'    => '',
            ],$Messages::$mypage['mypage']);
        }else{
            //수정
            //회원 정보를 찾아 놓음
            $user_info = DB::table('users')->where('id', $num)->first();
            $select_disp = CustomUtils::select_box("user_level","회원@@관리자","10@@3", "$user_info->user_level");

            if($user_info->user_type == "Y") $user_status = "탈퇴";
            else $user_status = "가입";

            return view('adm.member.memberregi',[
                'title_ment'            => '수정',
                'mode'                  => 'modi',
                'num'                   => $user_info->id,
                "type"                  => 'member_'.$user_info->id,   //원하는 첨부파일 경로와 순번 값을 함쳐서 보낸다.
                'user_id'               => $user_info->user_id,
                'user_name'             => $user_info->user_name,
                'user_pw'               => '',
                'user_pw_confirmation'  => '',
                'user_phone'            => $user_info->user_phone,
                'created_at'            => $user_info->created_at,
                'user_imagepath'        => $user_info->user_thumb_name,
                'user_ori_imagepath'    => $user_info->user_ori_imagepath,
                'select_disp'           => $select_disp,
                'user_status'           => $user_status,
                'withdraw_type'         => $user_info->withdraw_type,
                'withdraw_date'         => $user_info->withdraw_date,
                'withdraw_content'      => $user_info->withdraw_content,
                'user_point'            => $user_info->user_point,
                'user_type'             => $user_info->user_type,
                'user_gender'           => $user_info->user_gender,
                'user_birth'            => $user_info->user_birth,
                'blacklist'             => $user_info->blacklist,
                'site_access_no'        => $user_info->site_access_no,
                'user_platform_type'    => $user_info->user_platform_type,
            ],$Messages::$mypage['mypage']);
        }
    }

    public function pw_change(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_pw = trim($request->get('user_pw'));
        $user_pw_confirmation = trim($request->get('user_pw_confirmation'));
        $num        = $request->get('num');

        $validator = Validator::make($request->all(), [
            'user_pw'  => ['required', 'string', 'min:6', 'max:16', 'confirmed'],
            'user_pw_confirmation'  => ['required', 'string', 'min:6', 'max:16', 'same:user_pw'],
        ], $Messages::$mypage['validate']);


        $user_info = DB::table('users')->select('user_id', 'password')->where('id', $num)->first();
/*
//새로 들어온 비밀 번호가 현재 비밀 번호와 같으면 튕기게 하기
의도는 전 비밀 번호와 현 비밀 번호가 같으면 튕기게 하려 했으나
Auth::attempt($credentials) 응 통해 비교 했다가 비교 했던 아이디로 로그인 되어 버림
현재로선 그냥 비번 바꾸는 걸로...(21.07.14)

        $credentials = [
            'user_id' => $user_info->user_id,
            'password' => $user_pw,
        ];

        if (Auth::attempt($credentials))
        {
            //기존 비밀번호와 같을때 에러 처리
            return response()->json(['status_ment' => $Messages::$mypage['validate']['pwsame_false'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
*/

        $result_up = DB::table('users')->where('user_id', $user_info->user_id)->update(['password' => Hash::make($user_pw)]);

        if(!$result_up)
        {
            return response()->json(['status_ment' => $Messages::$fatal_fail_ment['fatal_fail']['error'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }else{
            return response()->json(['status_ment' => $Messages::$mypage['validate']['admpwchange_ok'],'status' => 'true'], 200, [], JSON_PRETTY_PRINT);
            exit;
        }
    }

    public function imgdel(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $num        = $request->input('num');

        $user_info = DB::table('users')->select('user_id', 'user_imagepath', 'user_thumb_name')->where('id', $num)->first();

        $img = "";
        $img_thumb = "";

        //기존 이미지가 있는지 체크
        if($user_info->user_imagepath != "")
        {
            //기존에 이미 이미지가 있는 상태임
            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_imagepath));
            if($deleted) $img = 'Y';
        }

        //기존 썸네일 이미지가 있는지 체크
        if($user_info->user_thumb_name != "")
        {
            //기존에 이미 썸네일 이미지가 있는 상태임
            $deleted = File::delete (public_path ('/data/member/'.$user_info->user_thumb_name));
            if($deleted) $img_thumb = 'Y';
        }

        $user = User::whereUser_id($user_info->user_id)->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
        $user->user_imagepath = "";
        $user->user_ori_imagepath = "";
        $user->user_thumb_name = "";
        $result_up = $user->save();

        if($img == "Y" && $img_thumb == "Y" && $result_up){
            return response()->json(['status_ment' => $Messages::$mypage['validate']['img_del_ok'],'status' => 'true'], 200, [], JSON_PRETTY_PRINT);
        }else{
            return response()->json(['status_ment' => $Messages::$fatal_fail_ment['fatal_fail']['error'],'status' => 'false'], 200, [], JSON_PRETTY_PRINT);
        }
    }

    public function member_out(Request $request)
    {
/*
        $admin_chk = CustomUtils::admin_access(Auth::user()->user_level,config('app.ADMIN_LEVEL'));
        if(!$admin_chk){    //관리자 권한이 없을때 메인으로 보내 버림
            return redirect()->route('main.index');
            exit;
        }
*/
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //탈퇴된 사람은 살리고, 안된 사람은 탈퇴 시기기 위해 회원 정보 불러옴
            $user_info = DB::table('users')->select('user_type')->where('id', $request->input('chk_id')[$i])->first();
            if($user_info->user_type == "Y") {
                $type_change = "N";
                $withdraw_type = "";
                $withdraw_content = "";
                $withdraw_date = "";
            }else{
                $type_change = "Y";
                $withdraw_type = "관리자 탈퇴";
                $withdraw_content = "관리자 탈퇴";
                $withdraw_date = now();
            }

            $user = User::whereid($request->input('chk_id')[$i])->first();  //update 할때 미리 값을 조회 하고 쓰면 update 구문으로 자동 변경
            $user->user_type = $type_change;
            $user->withdraw_type = $withdraw_type;
            $user->withdraw_content = $withdraw_content;
            $user->withdraw_date = $withdraw_date;
            $result_up = $user->save();
        }
        return redirect()->route('adm.member.index')->with('alert_messages', $Messages::$adm_mem_chk['mem_chk']['out_ok']);
    }

    public function member_point(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id = $request->input('num');

        //$members = DB::table('users')->where([['user_level','>','2'], ['id', $id]])->first();
        $members = DB::table('users')->where('id', $id)->first();

        if($members == ""){
            return redirect()->route('adm.member.index')->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $page       = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $shoppoints = DB::table("shoppoints")->where("user_id", $members->user_id)->whereRaw("po_type not in ('7', '11', '10')");

        $total_record   = 0;
        $total_record   = $shoppoints->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $shoppoint_rows = $shoppoints->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        $tailarr['num'] = $id;    //고정된 전달 파라메터가 있을때 사용

        $PageSet        = new PageSet;
        $showPage       = $PageSet->pageSet($total_page, $page, $pageScale, $blockScale, $total_record, $tailarr,"");
        $prevPage       = $PageSet->getPrevPage("이전");
        $nextPage       = $PageSet->getNextPage("다음");
        $pre10Page      = $PageSet->pre10("이전10");
        $next10Page     = $PageSet->next10("다음10");
        $preFirstPage   = $PageSet->preFirst("처음");
        $nextLastPage   = $PageSet->nextLast("마지막");
        $listPage       = $PageSet->getPageList();
        $pnPage         = $preFirstPage.$prevPage.$listPage.$nextPage.$nextLastPage;

        return view('adm.member.member_point', [
            'members'   => $members,
            'num'       => $id,
            'shoppoint_rows'    => $shoppoint_rows,
            'pnPage'            => $pnPage,
        ]);
    }

    public function member_use_point(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id = $request->input('num');

        //$members = DB::table('users')->where([['user_level','>','2'], ['id', $id]])->first();
        $members = DB::table('users')->where('id', $id)->first();

        if($members == ""){
            return redirect()->route('adm.member.index')->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $page       = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $shoppoints = DB::table("shoppoints")->where("user_id", $members->user_id)->whereRaw("po_type in ('7', '11', '10')");

        $total_record   = 0;
        $total_record   = $shoppoints->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $shoppoint_rows = $shoppoints->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        $tailarr['num'] = $id;    //고정된 전달 파라메터가 있을때 사용

        $PageSet        = new PageSet;
        $showPage       = $PageSet->pageSet($total_page, $page, $pageScale, $blockScale, $total_record, $tailarr,"");
        $prevPage       = $PageSet->getPrevPage("이전");
        $nextPage       = $PageSet->getNextPage("다음");
        $pre10Page      = $PageSet->pre10("이전10");
        $next10Page     = $PageSet->next10("다음10");
        $preFirstPage   = $PageSet->preFirst("처음");
        $nextLastPage   = $PageSet->nextLast("마지막");
        $listPage       = $PageSet->getPageList();
        $pnPage         = $preFirstPage.$prevPage.$listPage.$nextPage.$nextLastPage;

        return view('adm.member.member_use_point', [
            'members'   => $members,
            'num'       => $id,
            'shoppoint_rows'    => $shoppoint_rows,
            'pnPage'            => $pnPage,
        ]);
    }

    public function ajax_member_point_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id         = $request->input('num');
        $give_point = $request->input('give_point');
        $give_point_chk = $request->input('give_point_chk');

        $members = DB::table('users')->where([['user_level','>','2'], ['id', $id]])->first();

        if($members == ""){
            return redirect()->route('adm.member.index')->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        if($give_point_chk == 1){
            $save_give_point = $give_point;
            $CustomUtils->insert_point($members->user_id, $save_give_point, '지구랭 특별 적립', 17, '', '');
        }else if($give_point_chk == 2){
            $save_give_point = (-1) * $give_point;
            $CustomUtils->insert_point($members->user_id, $save_give_point, '지구랭 특별 적립 취소', 18, '', '');
        }

        echo "ok";
        exit;
    }


}
