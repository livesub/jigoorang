<?php
#############################################################################
#
#		파일이름		:		MainController.php
#		파일설명		:		프론트 메인 화면 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 20일
#		최종수정일		:		2021년 08월 20일
#
###########################################################################-->

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\DB;
use App\Models\User;    //모델 정의
use Illuminate\Support\Facades\Auth;    //인증

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    }

    public function index()
    {
        $CustomUtils = new CustomUtils;
        //초기 관리자 아이디가 없으면 관리자 아이디 생성 해 주게..
        //레벨이 3이하인 사람이 한명이라도 있는 지 파악
        $user_cnt = DB::table('users')->where('user_level', '<=', 3)->count();

        if($user_cnt == 0){
            //.env 파일에 정의 후 config/app.php 파일에서 읽어서 배열에 저장
            $admin_id = config('app.ADMIN_ID');
            $admin_pw = config('app.ADMIN_PW');
            $admin_name = config('app.ADMIN_NAME');
            $admin_create_level = config('app.ADMIN_CREATE_LEVEL');

            $create_result = User::create([
                'user_id' => $admin_id,
                'user_name' => $admin_name,
                'password' => Hash::make($admin_pw),
                'user_level' => $admin_create_level,
                'user_phone' => "01011112222",
                'user_activated' => 1,
            ])->exists(); //저장,실패 결과 값만 받아 오기 위해  exists() 를 씀
        }

        //상단 배너 관리
        $topbanner_infos = DB::table('banners')->where([['b_display', 'Y'], ['b_type', 1]])->get();

        //하단 배너 관리
        $bottombanner_infos = DB::table('banners')->where([['b_display', 'Y'], ['b_type', 2]])->get();

        //팝업 관리
        $pop_info = DB::table('popups')->where('pop_display', 'Y')->orderBy('id', 'desc')->limit(1)->first();

        //추천 랭킹 쿼리
        $recommend_ranks = DB::table('shopcategorys')->where([['sca_display', 'Y'], ['sca_rank_dispaly', 'Y']])->whereRaw('length(sca_id) = 4')->inRandomOrder()->get();

        //기획전 멘트 관리자 변경 가져 오기
        $sett = $CustomUtils->setting_infos();
        $special_one_ment = $sett->de_ment_change;
        $special_two_ment = $sett->de_ment_change2;

        //기획전 쿼리
        $special_ones = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_soldout', '0'], ['item_special', '1']])->orderBy('item_rank','asc')->orderBy('id','desc')->get();
        $special_twos = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_soldout', '0'], ['item_special2', '1']])->orderBy('item_rank','asc')->orderBy('id','desc')->get();
        $new_arrivals = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_soldout', '0'], ['item_new_arrival', '1']])->orderBy('item_rank','asc')->orderBy('id','desc')->get();

        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        return view('main',[
            'topbanner_infos'       => $topbanner_infos,
            'bottombanner_infos'    => $bottombanner_infos,
            'CustomUtils'           => $CustomUtils,
            'recommend_ranks'       => $recommend_ranks,
            'special_one_ment'      => $special_one_ment,
            'special_two_ment'      => $special_two_ment,
            'special_ones'          => $special_ones,
            'special_twos'          => $special_twos,
            'new_arrivals'          => $new_arrivals,
            'pop_info'              => $pop_info,
        ],$Messages::$main['main']);
    }
}
