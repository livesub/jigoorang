<?php
#############################################################################
#
#		파일이름		:		NoticeController.php
#		파일설명		:		지구를 구하는기록
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 26일
#		최종수정일		:		2022년 01월 26일
#
###########################################################################-->

namespace App\Http\Controllers\notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notice(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $pageScale  = 10;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $notices = DB::table('notices');

        $total_record   = 0;
        $total_record   = $notices->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $notice_rows = $notices->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        //$tailarr['AA'] = 'AA';    //고정된 전달 파라메터가 있을때 사용

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

        return view('notice.notice',[
            'notice_infos'  => $notice_rows,
            'virtual_num'   => $virtual_num,
            'pnPage'        => $pnPage,
            'page'          => $page,
        ]);
    }

    public function notice_view(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id     = $request->input('id');
        $page   = $request->input('page');

        $notice_info = DB::table('notices')->where('id', $id)->first();
        if($notice_info == ""){
            return redirect(route('notice'))->with('alert_messages', '잘못된 경로 입니다.');  //치명적인 에러가 있을시
        }

        $pre = DB::select(" select id from notices where id =(select max(id) from notices where id < $id) ");
        $next = DB::select(" select id from notices where id =(select min(id) from notices where id > $id) ");

        $pre_cnt = count($pre);
        $next_cnt = count($next);

        $link = 'page='.$page;
        $pre_link = '';
        $next_link = '';

        if($pre_cnt > 0) $pre_link = 'id='.$pre[0]->id.'&page='.$page;
        if($next_cnt > 0) $next_link = 'id='.$next[0]->id.'&page='.$page;


        return view('notice.notice_view',[
            'CustomUtils'   => $CustomUtils,
            'notice_info'   => $notice_info,
            'page'          => $page,
            'link'          => $link,
            'pre_link'      => $pre_link,
            'next_link'     => $next_link,
            'pre_cnt'       => $pre_cnt,
            'next_cnt'      => $next_cnt,
        ]);

    }
}
