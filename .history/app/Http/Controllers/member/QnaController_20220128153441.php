<?php
#############################################################################
#
#		파일이름		:		QnaController.php
#		파일설명		:		1:1 문의 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 12월 14일
#		최종수정일		:		2021년 12월 14일
#
###########################################################################-->

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\qnas;

class QnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $page       = $request->input('page');
        $keyword    = $request->input('keyword');

        $pageScale  = 10;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $qna_list = DB::table('qnas')->where('user_id', Auth::user()->user_id);

        if($keyword != ""){
            $qna_list->where('qna_subject', 'like', '%'.$keyword.'%')->orWhere('qna_content', 'like', '%'.$keyword.'%');
        }

        $total_record   = 0;
        $total_record   = $qna_list->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $qna_rows = $qna_list->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
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

        return view('member.qnalist',[
            'CustomUtils'       => $CustomUtils,
            'qna_rows'          => $qna_rows,
            'pnPage'            => $pnPage,
            'virtual_num'       => $virtual_num,
            'keyword'           => $keyword,
            'page'              => $page,
        ]);
    }

    public function qna_write(Request $request)
    {
        $CustomUtils = new CustomUtils;

        return view('member.qnawrite',[
        ]);
    }

    public function qna_write_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $qna_cate       = $request->input('qna_cate');
        $qna_subject    = addslashes($request->input('qna_subject'));
        $qna_content    = $request->input('qna_content');

        $data = array(
            'qna_cate'      => $qna_cate,
            'user_id'       => Auth::user()->user_id,
            'user_name'     => Auth::user()->user_name,
            'qna_subject'   => $qna_subject,
            'qna_content'   => $qna_content,
        );

        //저장 처리
        $create_result = qnas::create($data);
        $create_result->save();

        if($create_result){
            //return redirect(route('customer_center'))->with('alert_messages', '문의 주셔서 감사합니다.\n답변은 [마이페이지] - [나의 문의내역]에서 확인하실 수 있습니다.\n최대한 빠르게 답변 드리겠습니다.');
            return "<script>if (confirm('문의 주셔서 감사합니다.\\n답변은 [마이페이지] - [나의 문의내역]에서 확인하실 수 있습니다.\\n최대한 빠르게 답변 드리겠습니다.') == true){ location.href='".route('mypage.qna_list')."' }else{ location.href='".route('customer_center')."' }</script>";
        }
        else return redirect(route('customer_center'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');  //치명적인 에러가 있을시
    }

    public function qna_view(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id         = $request->input('id');
        $page       = $request->input('page');
        $keyword    = $request->input('keyword');

        $qna_info = DB::table('qnas')->where([['id', $id], ['user_id', Auth::user()->user_id]])->first();
        if($qna_info == ""){
            return redirect(route('mypage.qna_list'))->with('alert_messages', '잘못된 경로 입니다.');  //치명적인 에러가 있을시
        }

        $add_where = '';
        if($keyword != ""){
            //$qna_list->where('qna_subject', 'like', '%'.$keyword.'%')->orWhere('qna_content', 'like', '%'.$keyword.'%');
            $add_where = " and (qna_subject like '%$keyword%' or qna_content like '%$keyword%') ";
        }

        $auth_user_id = Auth::user()->user_id;
        $pre = DB::select(" select id from qnas where id =(select max(id) from qnas where user_id = '$auth_user_id' and id < $id $add_where) ");
        $next = DB::select(" select id from qnas where id =(select min(id) from qnas where user_id = '$auth_user_id' and id > $id $add_where) ");

        $pre_cnt = count($pre);
        $next_cnt = count($next);
        $link = 'page='.$page.'&keyword='.$keyword;

        $pre_link = '';
        $next_link = '';

        if($pre_cnt > 0) $pre_link = 'id='.$pre[0]->id.'&page='.$page.'&keyword='.$keyword;
        if($next_cnt > 0) $next_link = 'id='.$next[0]->id.'&page='.$page.'&keyword='.$keyword;

        return view('member.qna_view',[
            'CustomUtils'   => $CustomUtils,
            'qna_info'      => $qna_info,
            'page'          => $page,
            'keyword'       => $keyword,
            'link'          => $link,
            'pre_link'      => $pre_link,
            'next_link'     => $next_link,
            'pre_cnt'       => $pre_cnt,
            'next_cnt'      => $next_cnt,
        ]);
    }

}
