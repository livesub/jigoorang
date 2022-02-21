<?php
#############################################################################
#
#		파일이름		:		RankingController.php
#		파일설명		:		지구를 구하는 랭킹
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 26일
#		최종수정일		:		2022년 01월 26일
#
###########################################################################-->

namespace App\Http\Controllers\ranking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ranking_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $rank_cate_infos = DB::table('shopcategorys')->where([['sca_display', 'Y'], ['sca_rank_dispaly', 'Y']])->whereRaw('length(sca_id) = 4')->orderby('sca_rank', 'asc')->orderby('id', 'desc')->get();

        return view('ranking.ranking',[
            'rank_cate_infos'   => $rank_cate_infos,
        ]);
    }

    public function ranking_view(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $sca_id     = $request->input('sca_id');
        $sub_cate   = $request->input('sub_cate');
        $item_name_num = $request->input('item_name_num');

        $rank_cate_navi = DB::table('shopcategorys')->select('sca_name_kr', 'sca_id')->where('sca_id', $sca_id)->first();
        if($rank_cate_navi == ""){
            return redirect(route('ranking_list'))->with('alert_messages', '잘못된 경로 입니다.');  //치명적인 에러가 있을시
        }

        $rank_cate_infos = DB::table('shopcategorys')->where([['sca_display', 'Y'], ['sca_rank_dispaly', 'Y']])->whereRaw('length(sca_id) = 4')->orderby('sca_rank', 'asc')->orderby('id', 'desc')->get();

        //정량 평가 항목 가져 오기
        $rating_item_info = DB::table('rating_item')->where('sca_id', $sca_id)->orderby('id', 'asc')->first();
        if($rating_item_info == ''){
            return redirect(route('ranking_list'))->with('alert_messages', '정량 평가 항목이 없습니다');  //치명적인 에러가 있을시
        }

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

        $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display','Y'], ['sca_id', $sca_id], ['avg_score5', '!=' ,'0']]);
        //$item_sql = DB::table('shopitems');

        $total_record   = 0;
        $total_record   = $item_sql->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        if($item_name_num == ""){
            $avg_score = "avg_score5";
        }else{
            $avg_score = "avg_score".$item_name_num;
        }
var_dump($avg_score);
        $item_infos = $item_sql->orderBy($avg_score, 'desc')->orderBy('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        //$virtual_num = $total_record - $pageScale * ($page - 1);
        $virtual_num =  1 + $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['sca_id'] = $sca_id;
        $tailarr['sub_cate'] = $sub_cate;
        $tailarr['item_name_num'] = $item_name_num;

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

        return view('ranking.ranking_view',[
            'rank_cate_navi'    => $rank_cate_navi,
            'sca_id'            => $sca_id,
            'sub_cate'          => $sub_cate,
            'item_name_num'     => $item_name_num,
            'avg_score'         => $avg_score,
            'rank_cate_infos'   => $rank_cate_infos,
            'rating_item_info'  => $rating_item_info,
            'item_infos'        => $item_infos,
            'pnPage'            => $pnPage,
            'page'              => $page,
            'virtual_num'       => $virtual_num,
            'CustomUtils'       => $CustomUtils,
        ]);
    }

    public function avg_test(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $review_saves_infos = DB::table('review_saves')->select('item_code')->where([['temporary_yn', 'n'], ['review_blind', 'N']])->distinct()->get();
        foreach($review_saves_infos as $review_saves_info){
            $CustomUtils->item_average($review_saves_info->item_code);
        }

        dd("ok!!");
    }

}
