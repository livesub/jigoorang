<?php
#############################################################################
#
#		파일이름		:		SearchController.php
#		파일설명		:		검색관리
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 26일
#		최종수정일		:		2022년 01월 26일
#
###########################################################################-->

namespace App\Http\Controllers\search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $search_w       = $request->input('search_w');
        $orderby_type   = $request->input('orderby_type');

        $item_cnt = 0;
        $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]]);

        if($orderby_type != ""){
            switch ($orderby_type) {
                case 'recent':
                    $item_sql = $item_sql->orderby('id','DESC')->get();
                    $item_cnt = $item_sql->count();
                    break;
                case 'sale':
                    //$orderby_add = "'total', 'desc'";
                    $item_sql = DB::table('shopitems as a')
                    ->select('a.*', DB::raw('count(b.item_code) as total'))
                    ->leftjoin('shopcarts as b', function($join) {
                            $join->on('a.item_code', '=', 'b.item_code')->whereRaw('b.sct_status in (\'입금\', \'준비\', \'배송\', \'완료\')');
                        });
                    $item_sql = $item_sql->where([['item_del', 'N'], ['item_display', 'Y']])->whereRaw("a.item_name like '%{$search_w}%'");
                    $item_sql = $item_sql->groupBy('a.item_code')->orderBy('total', 'desc')->get();
                    $item_cnt = $item_sql->count();
                    break;
                case 'high_price':
                    //$orderby_add = "'item_price', 'DESC'";
                    $item_sql = $item_sql->orderby('item_price','DESC')->get();
                    $item_cnt = $item_sql->count();
                    break;
                case 'low_price':
                    //$orderby_add = "'item_price', 'ASC'";
                    $item_sql = $item_sql->orderby('item_price','ASC')->get();
                    $item_cnt = $item_sql->count();
                    break;
                case 'review':
                    //$orderby_add = "'review_cnt', 'DESC'";
                    $item_sql = $item_sql->orderby('review_cnt','DESC')->get();
                    $item_cnt = $item_sql->count();
                    break;
                default:
                    //$orderby_add = "'id', 'DESC'";
                    $item_sql = $item_sql->orderby('id','DESC')->get();
                    $item_cnt = $item_sql->count();
            }
        }else{
            $item_sql = $item_sql->orderby('item_rank', 'ASC')->orderby('id','DESC')->get();
            $item_cnt = $item_sql->count();
        }

        $date = date("Y-m-d", time());
        $notice_sql = DB::table('notices')->where('n_subject', 'LIKE', "%$search_w%")->orderby('id', 'desc')->get();
        $exp_sql = DB::table('exp_list')->where([['title', 'LIKE', "%$search_w%"], ['exp_review_end', '>=', $date]])->orderby('id', 'desc')->get();

        $total_cnt = $item_cnt + count($notice_sql) + count($exp_sql);

        return view('search.search_all',[
            'item_infos'    => $item_sql,
            'notice_infos'  => $notice_sql,
            'exp_infos'     => $exp_sql,
            'search_w'      => $search_w,
            'total_cnt'     => $total_cnt,
            'item_cnt'      => $item_cnt,
            'orderby_type'  => $orderby_type,
            'CustomUtils'   => $CustomUtils,
        ]);
    }

    public function search_shop(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $search_w       = $request->input('search_w');
        $orderby_type   = $request->input('orderby_type');
        $page       = $request->input('page');

        $item_cnt = 0;

        $pageScale  = 20;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]]);

        if($orderby_type != ""){
            switch ($orderby_type) {
                case 'recent':
                    $item_sql = $item_sql->orderby('id','DESC');
                    $item_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'sale':
                    $item_sql = DB::table('shopitems as a')
                    ->select('a.*', DB::raw('count(b.item_code) as total'))
                    ->leftjoin('shopcarts as b', function($join) {
                            $join->on('a.item_code', '=', 'b.item_code')->whereRaw('b.sct_status in (\'입금\', \'준비\', \'배송\', \'완료\')');
                        });
                    $item_sql = $item_sql->where([['item_del', 'N'], ['item_display', 'Y']])->whereRaw("a.item_name like '%{$search_w}%'");
                    $item_sql = $item_sql->groupBy('a.item_code')->orderBy('total', 'desc');
                    $item_cnt_tmp = $item_sql->get();
                    $item_cnt = count($item_cnt_tmp);
                    $item_sql = $item_sql->offset($start_num)->limit($pageScale)->get();
                    $item_infos = $item_sql;
                    break;
                case 'high_price':
                    $item_sql = $item_sql->orderby('item_price','DESC');
                    $item_cnt = $item_sql->count();
                    $item_infos = $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'low_price':
                    $item_sql = $item_sql->orderby('item_price','ASC');
                    $item_cnt = $item_sql->count();
                    $item_infos = $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'review':
                    $item_sql = $item_sql->orderby('review_cnt','DESC');
                    $item_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                default:
                    $item_sql = $item_sql->orderby('id','DESC');
                    $item_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
            }
        }else{
            $item_cnt = $item_sql->count();
            $item_infos = $item_sql->orderby('item_rank', 'ASC')->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        }

        $date = date("Y-m-d", time());
        $notice_sql = DB::table('notices')->where('n_subject', 'LIKE', "%$search_w%")->get();
        $exp_sql = DB::table('exp_list')->where([['title', 'LIKE', "%$search_w%"], ['exp_review_end', '>=', $date]])->get();

        $total_cnt = $item_cnt + count($notice_sql) + count($exp_sql);

        $total_record   = 0;
        $total_record   = $item_cnt; //총 게시물 수

        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['search_w'] = $search_w;    //고정된 전달 파라메터가 있을때 사용
        $tailarr['orderby_type'] = $orderby_type;

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

        return view('search.search_shop',[
            'item_infos'    => $item_infos,
            'notice_infos'  => $notice_sql,
            'exp_infos'     => $exp_sql,
            'search_w'      => $search_w,
            'total_cnt'     => $total_cnt,
            'item_cnt'      => $item_cnt,
            'orderby_type'  => $orderby_type,
            'CustomUtils'   => $CustomUtils,
            'page'          => $page,
            'pnPage'        => $pnPage,
        ]);
    }

    public function search_notice(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $search_w       = $request->input('search_w');
        $orderby_type   = $request->input('orderby_type');
        $page       = $request->input('page');

        $item_cnt = 0;

        $pageScale  = 20;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]])->get();

        $notice_sql = DB::table('notices')->where('n_subject', 'LIKE', "%$search_w%");
        $notice_cnt = $notice_sql->count();
        $notice_infos = $notice_sql->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        $date = date("Y-m-d", time());
        $exp_sql = DB::table('exp_list')->where([['title', 'LIKE', "%$search_w%"], ['exp_review_end', '>=', $date]])->orderby('id', 'desc')->get();

        $total_cnt = count($item_sql) + $notice_cnt + count($exp_sql);

        $total_record   = 0;
        $total_record   = $notice_cnt; //총 게시물 수

        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['search_w'] = $search_w;    //고정된 전달 파라메터가 있을때 사용
        $tailarr['orderby_type'] = $orderby_type;

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

        return view('search.search_notice',[
            'item_infos'    => $item_sql,
            'notice_cnt'    => $notice_cnt,
            'notice_infos'  => $notice_infos,
            'exp_infos'     => $exp_sql,
            'search_w'      => $search_w,
            'total_cnt'     => $total_cnt,
            'item_cnt'      => $item_cnt,
            'orderby_type'  => $orderby_type,
            'CustomUtils'   => $CustomUtils,
            'page'          => $page,
            'pnPage'        => $pnPage,
        ]);
    }

    public function search_exp(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $search_w       = $request->input('search_w');
        $orderby_type   = $request->input('orderby_type');
        $page       = $request->input('page');

        $item_cnt = 0;

        $pageScale  = 20;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]])->get();
        $notice_sql = DB::table('notices')->where('n_subject', 'LIKE', "%$search_w%")->get();

        $date = date("Y-m-d", time());
        $exp_sql = DB::table('exp_list')->where([['title', 'LIKE', "%$search_w%"], ['exp_review_end', '>=', $date]]);
        $exp_cnt = $exp_sql->count();
        $exp_infos = $exp_sql->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();
        $total_cnt = count($item_sql) + count($notice_sql) + $exp_cnt;

        $total_record   = 0;
        $total_record   = $exp_cnt; //총 게시물 수

        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['search_w'] = $search_w;    //고정된 전달 파라메터가 있을때 사용
        $tailarr['orderby_type'] = $orderby_type;

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

        return view('search.search_exp',[
            'item_infos'    => $item_sql,
            'exp_cnt'       => $exp_cnt,
            'notice_infos'  => $notice_sql,
            'exp_infos'     => $exp_infos,
            'search_w'      => $search_w,
            'total_cnt'     => $total_cnt,
            'item_cnt'      => $item_cnt,
            'orderby_type'  => $orderby_type,
            'CustomUtils'   => $CustomUtils,
            'page'          => $page,
            'pnPage'        => $pnPage,
        ]);
    }


}
