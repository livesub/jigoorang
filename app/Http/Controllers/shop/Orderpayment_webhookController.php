<?php
#############################################################################
#
#		파일이름		:		Orderpayment_webhookController.php
#		파일설명		:		아임포트 결제 저장 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 03월 02일
#		최종수정일		:		2022년 03월 02일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Http\Controllers\shop\OrderController;

class Orderpayment_webhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderpayment_webhook(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $imp_uid = $request->imp_uid;
        $merchant_uid = $request->merchant_uid;
        $status = $request->status;

        if($request->status == "paid"){

            $merchant_uid = str_replace('merchant_','',$merchant_uid);
            $order_chk = DB::table('shoporders')->where('order_id', $merchant_uid)->count();
            if($order_chk == 0){
                $payment = new OrderController();
                //$imp_uid = 'imp_858833453231';
                //$merchant_uid = '2022030215002999';
                $request['imp_uid'] = $imp_uid;
                $request['order_id'] = $merchant_uid;
                $payment->orderpayment($request);
            }            
        }
    }
}
