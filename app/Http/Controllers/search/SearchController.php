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
        $item_sql = DB::table('shopitems')->where([['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]]);

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
                    $item_sql = $item_sql->whereRaw("a.item_name like '%{$search_w}%'");
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
            $item_sql = $item_sql->orderby('id','DESC')->get();
            $item_cnt = $item_sql->count();
        }

        $date = date("Y-m-d", time());
        $notice_sql = DB::table('notices')->where('n_subject', 'LIKE', "%$search_w%")->get();
        $exp_sql = DB::table('exp_list')->where([['title', 'LIKE', "%$search_w%"], ['exp_review_end', '>=', $date]])->get();

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

        $item_cnt = 0;
        $item_sql = DB::table('shopitems')->where([['item_display', 'Y'], ['item_name', 'LIKE', "%$search_w%"]]);

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
                    $item_sql = $item_sql->whereRaw("a.item_name like '%{$search_w}%'");
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
            $item_sql = $item_sql->orderby('id','DESC')->get();
            $item_cnt = $item_sql->count();
        }

        return view('search.search_shop',[
            'item_infos'    => $item_sql,
            'search_w'      => $search_w,
            'total_cnt'     => $total_cnt,
            'item_cnt'      => $item_cnt,
            'orderby_type'  => $orderby_type,
            'CustomUtils'   => $CustomUtils,
        ]);
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
