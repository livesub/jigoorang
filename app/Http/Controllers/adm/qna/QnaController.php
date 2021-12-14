<?php
#############################################################################
#
#		파일이름		:		QnaController.php
#		파일설명		:		관리자 1:1 문의 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 12월 14일
#		최종수정일		:		2021년 12월 14일
#
###########################################################################-->

namespace App\Http\Controllers\adm\qna;

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
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $qna_list = DB::table('qnas');

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

        return view('adm.qna.qnalist',[
            'CustomUtils'       => $CustomUtils,
            'qna_rows'          => $qna_rows,
            'pnPage'            => $pnPage,
            'virtual_num'       => $virtual_num,
            'keyword'           => $keyword,
            'page'              => $page,
        ]);
    }

    public function qna_answer(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id         = $request->input('id');
        $page       = $request->input('page');
        $keyword    = $request->input('keyword');

        $qna_info = DB::table('qnas')->where('id', $id)->first();

        return view('adm.qna.qna_answer',[
            'CustomUtils'       => $CustomUtils,
            'qna_info'          => $qna_info,
            'page'              => $page,
            'keyword'           => $keyword,
        ]);
    }

    public function qna_answer_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id         = $request->input('id');
        $page       = $request->input('page');
        $keyword    = $request->input('keyword');
        $qna_answer = $request->input('qna_answer');

        $update_result = qnas::find($id)->update(['qna_answer' => $qna_answer]);

        $link = '?page='.$page.'&keyword='.$keyword;

        if($update_result) return redirect(route('adm.qna_list', $link))->with('alert_messages', '답변이 등록 되었습니다.');
        else return redirect(route('adm.qna_list', $link))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');  //치명적인 에러가 있을시
    }








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
