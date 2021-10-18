<?php
#############################################################################
#
#		파일이름		:		SendcostController.php
#		파일설명		:		관리자 쇼핑몰 추가 배송비 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 18일
#		최종수정일		:		2021년 10월 18일
#
###########################################################################-->

namespace App\Http\Controllers\adm\shop\sendcost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\sendcosts;    //추가 배송비 모델 정의

class SendcostController extends Controller
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

    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sendcosts = DB::table('sendcosts')->orderby('id','desc')->get();
        return view('adm.shop.sendcost.sendcostlist',[
            'sendcosts' => $sendcosts,
        ]);
    }

    public function ajax_regi_sendcost(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sc_name    = $request->input('sc_name');
        $sc_zip1    = $request->input('sc_zip1');
        $sc_zip2    = $request->input('sc_zip2');
        $sc_price   = $request->input('sc_price');

        //저장 처리
        $create_result = sendcosts::create([
            "sc_name"   => $sc_name,
            "sc_zip1"   => $sc_zip1,
            "sc_zip2"   => $sc_zip2,
            "sc_price"  => $sc_price,
        ]);
        $create_result->save();

        echo "ok";
        exit;
    }

    public function ajax_del_sendcost(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $chk    = $request->input('chk');
        for($i = 0; $i < count($chk); $i++){
            DB::table('sendcosts')->where('id',$chk[$i])->delete();   //옵션 row 삭제
        }

        echo "ok";
        exit;
    }
}
