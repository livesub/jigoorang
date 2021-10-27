<?php
#############################################################################
#
#		파일이름		:		BaesongjiController.php
#		파일설명		:		배송지 처리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 08일
#		최종수정일		:		2021년 10월 08일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\baesongjis;    //배송지 모델 정의

class BaesongjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        session_start();
        $this->middleware('auth');
    }

    public function ajax_baesongji(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        if(!Auth::user()){
            echo "no_mem";
            exit;
        }

        $baesongjis = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->orderBy('ad_default', 'desc')->orderBy('id', 'desc')->get();

        $view = view('shop.ajax_baesongji',[
            'baesongjis'    => $baesongjis,
        ]);

        return $view;
    }

    public function ajax_baesongji_modify(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $chk        = $request->input('chk');
        $id_ori       = $request->input('id_ori');
        $ad_subject = $request->input('ad_subject_ori');
        $ad_default = $request->input('ad_default_ori');

        if(!Auth::user() || count($chk) == 0){
            echo "no_mem";
            exit;
        }

        $baesong_cnt = DB::table('baesongjis')->where('user_id',Auth::user()->user_id)->count();

        $id_val = '';
        $ad_subject_val = '';
        for($i = 0; $i < $baesong_cnt; $i++)
        {
            $k = isset($chk[$i]) ? (int)$chk[$i] : 0;
            if($k == 1){
                $id_val = $id_ori[$i];
                $ad_subject_val = $ad_subject[$i];
/*
                //if(!empty($ad_default) && $id === $ad_default) {  //$id === $ad_default 이부분 처리 해야함
                if(!empty($ad_default)) {
                    $update_result = DB::table('baesongjis')->where([['id', $id_val], ['user_id',Auth::user()->user_id]])->limit(1)->update(['ad_subject' => $ad_subject_val, 'ad_default' => 1]);
                }else{
                    $update_result = DB::table('baesongjis')->where([['id', $id_val], ['user_id',Auth::user()->user_id]])->limit(1)->update(['ad_subject' => $ad_subject_val]);
                }
*/
                $update_result = DB::table('baesongjis')->where([['id', $id_val], ['user_id',Auth::user()->user_id]])->limit(1)->update(['ad_subject' => $ad_subject_val]);
            }
        }

        echo "ok";
        exit;
    }

    public function ajax_baesongji_register(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $view = view('shop.ajax_baesongji_regi',[
        ]);

        return $view;
    }

    public function ajax_baesongji_save(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $user_id            = Auth::user()->user_id;
        $ad_c_subject       = $request->input('ad_c_subject');
        $od_c_name          = $request->input('od_c_name');
        $od_c_zip           = $request->input('od_c_zip');
        $od_c_addr1         = $request->input('od_c_addr1');
        $od_c_addr2         = $request->input('od_c_addr2');
        $od_c_addr3         = $request->input('od_c_addr3');
        $od_c_addr_jibeon   = $request->input('od_c_addr_jibeon');
        $od_c_tel           = $request->input('od_c_tel');
        $od_c_hp            = $request->input('od_c_hp');
        $ad_default         = $request->input('ad_default');

        $CustomUtils->baesongji_process($ad_default, $ad_c_subject, $od_c_name, $od_c_tel, $od_c_hp, $od_c_zip, $od_c_addr1, $od_c_addr2, $od_c_addr3, $od_c_addr_jibeon);

        echo "ok";
        exit;
    }

    public function ajax_baesongji_delete(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $id         = $request->input('num');
        $user_id    = Auth::user()->user_id;

        DB::table('baesongjis')->where([['id', $id],['user_id',$user_id]])->delete();   //row 삭제

        echo "ok";
        exit;
    }

    public function ajax_ordersendcost(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $code         = $request->input('zipcode');

        $sendcost = DB::table('sendcosts')->select('id', 'sc_price')->where([['sc_zip1', '<=', $code], ['sc_zip2', '>=', $code]])->first();

        if(is_null($sendcost)){
            echo "no_sendcost";
            exit;
        }else{
            echo json_encode($sendcost);
            exit;
        }
    }

    public function ajax_baesongji_change(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $id         = $request->input('id');

        $baesongji_info = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['id', $id]])->first();

        $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
            'user_zip'          => $baesongji_info->ad_zip1,
            'user_addr1'        => $baesongji_info->ad_addr1,
            'user_addr2'        => $baesongji_info->ad_addr2,
            'user_addr3'        => $baesongji_info->ad_addr3,
            'user_addr_jibeon'  => $baesongji_info->ad_jibeon,
        ]);

        //기본 배송지 컬럼(ad_default) 전부 0으로 만듦
        $update_default = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->update(['ad_default' => 0]);

        $update_result = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['id', $id]])->update(['ad_default'=> 1]);

        echo "ok";
        exit;
    }

}
