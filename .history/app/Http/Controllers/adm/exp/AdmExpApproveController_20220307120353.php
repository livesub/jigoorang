<?php
#############################################################################
#
#		파일이름		:		AdmExpApproveController.php
#		파일설명		:		관리자페이지 체험단 승인 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 22일
#		최종수정일		:		2021년 11월 22일
#
###########################################################################-->

namespace App\Http\Controllers\adm\exp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크

class AdmExpApproveController extends Controller
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
        $CustomUtils = new CustomUtils;

        $exp_id     = $request->input('exp_id');
        $seach_select     = $request->input('seach_select');
        $seach_keyword     = $request->input('seach_keyword');


        $exp_last = DB::table('exp_list')->orderBy('id', 'DESC')->limit(1)->first();

        $exp_lists = DB::table('exp_list')->orderBy('id', 'DESC')->get();

        //$exp_application_info = DB::table('exp_application_list');

        $exp_application_info = DB::table('exp_application_list as a')
            ->select('a.*','b.user_phone')
            ->leftjoin('users as b', function($join) {
                    $join->on('a.user_id', '=', 'b.user_id');
                });

        if($exp_id == ''){
            if(is_null($exp_last)){
                $exp_application_lists = $exp_application_info;
            }else{
                $exp_application_lists = $exp_application_info->where('a.exp_id', $exp_last->id);
            }
        }else{
            $exp_application_lists = $exp_application_info->where('a.exp_id', $exp_id);
        }

        if($seach_select != ""){
            if($seach_select == "user_name") $exp_application_lists = $exp_application_info->where('b.user_name', 'like', '%'.$seach_keyword.'%');
            else if($seach_select == "user_id") $exp_application_lists = $exp_application_info->where('b.user_id', 'like', '%'.$seach_keyword.'%');
            else if($seach_select == "user_phone") $exp_application_lists = $exp_application_info->where('b.user_phone', 'like', '%'.$seach_keyword.'%');
        }

        $total_record   = 0;
        $total_record   = $exp_application_lists->count(); //총 게시물 수

        $exp_app_lists  = $exp_application_lists->orderBy('id')->get();

        $virtual_num = $total_record;

        return view('adm.exp.exp_approve_list',[
            'exp_lists'     => $exp_lists,
            'exp_id'        => $exp_id,
            'exp_app_lists' => $exp_app_lists,
            'virtual_num'   => $virtual_num,
            'exp_last'      => $exp_last,
            'total_record'  => $total_record,
            'seach_select'  => $seach_select,
            'seach_keyword' => $seach_keyword,
        ]);
    }

    public function approve_ok(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $exp_id = $request->input('exp_id');
        $chk    = $request->input('chk');

        if($exp_id == ''){
            echo "no";
            exit;
        }

        $update = DB::table('exp_application_list')->where('exp_id', $exp_id)->update(['access_yn' => 'n']);

        if($chk != ""){
            for($i = 0; $i < count($chk); $i++){
                $update_chk = DB::table('exp_application_list')->where([['exp_id', $exp_id], ['id', $chk[$i]]])->update(['access_yn' => 'y']);
            }
        }

        echo "yes";
        exit;
    }

}
