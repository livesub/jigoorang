<?php
#############################################################################
#
#		파일이름		:		ShopWishController.php
#		파일설명		:		Wish 리스트 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 22일
#		최종수정일		:		2021년 10월 22일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\wishs;    //wish 모델 정의

class ShopWishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth'); //회원만 들어 오기
    }

    public function ajax_wish(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code  = $request->input('item_code');

        //선택된 상품이 존재 하는지 체크
        $item_chk = DB::table('shopitems')->where('item_code', $item_code)->count();

        if($item_chk == 0){
            echo "no_item";
            exit;
        }

        //이미 wish 에 저장 되었는지 파악
        $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $item_code]])->count();
        $wi_ip = $_SERVER['REMOTE_ADDR'];
        if($wish_chk == 0){

            $create_result = wishs::create([
                'user_id'     => Auth::user()->user_id,
                'item_code' => $item_code,
                'wi_ip'     => $wi_ip,
            ]);
            $create_result->save();



            echo "ok";
            exit;
        }
    }
}
