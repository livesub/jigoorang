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
use App\Helpers\Custom\PageSet; //페이지 함수

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

        $page       = $request->input('page');

        $pageScale  = 10;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $sendcosts = DB::table('sendcosts');

        $total_record   = 0;
        $total_record   = $sendcosts->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $sendcost_rows = $sendcosts->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        //$tailarr['user_type'] = $user_type;


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
        return view('adm.shop.sendcost.sendcostlist',[
            'sendcosts' => $sendcost_rows,
        ]);
    }

    public function ajax_regi_sendcost(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sc_name    = $request->input('sc_name');
        $sc_zip1    = $request->input('sc_zip1');
        $sc_zip2    = $request->input('sc_zip2');
        $sc_price   = $request->input('sc_price');
        $act        = $request->input('act');
        $id        = $request->input('num');

        $data = array(
            "sc_name"   => $sc_name,
            "sc_zip1"   => $sc_zip1,
            "sc_zip2"   => $sc_zip2,
            "sc_price"  => $sc_price,
        );

        if($act != "modi"){
            //저장 처리
            $create_result = sendcosts::create($data);
            $create_result->save();
        }else{
            $update_result = DB::table('sendcosts')->where('id', $id)->update($data);
        }

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

    public function ajax_modi_sendcost(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        $id    = $request->input('num');

        $sendcosts = DB::table('sendcosts')->where('id',$id)->first();

        echo json_encode($sendcosts);
        exit;
    }

}
