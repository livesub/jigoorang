<?php
#############################################################################
#
#		파일이름		:		ReviewPossibleController.php
#		파일설명		:		mypage 체험단 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 23일
#		최종수정일		:		2021년 11월 23일
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

class ReviewPossibleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $CustomUtils = new CustomUtils;

        $now_date = date('Y-m-d', time());

        //체험단 쿼리
        $exp_appinfos = DB::table('exp_application_list as a')
            ->select('b.*','a.created_at as regi_date')
            ->join('exp_list as b', function($join) {
                    $join->on('a.exp_id', '=', 'b.id');
                })
            ->where([['b.exp_review_end', '>=', $now_date], ['a.user_id', Auth::user()->user_id], ['a.access_yn','y'], ['a.write_yn', 'n']])
            ->orderBy('a.created_at', 'DESC')
            ->get();



        //쇼핑몰 쿼리
        $carts = DB::table('shopcarts as a')
            ->select('a.*','b.created_at as regi_date')
            ->leftjoin('shoporders as b', function($join) {
                $join->on('a.od_id', '=', 'b.order_id');
                })
            ->where([['b.user_id', Auth::user()->user_id], ['a.sct_qty','!=', '0'], ['a.review_yn', 'n']])
            ->where('b.created_at', '>=', 'DATE_SUB(b.created_at, INTERVAL 15 DAY))')
            //->where('b.created_at', '<=', DATE_ADD('(2021-11-10, INTERVAL 30 DAY)'))
            //->whereRaw('b.created_at', '>=', DATE_ADD('2021-11-10', 'INTERVAL 30 DAY'))
            ->orderBy('b.created_at', 'DESC')
            ->get();

dd($carts);


        return view('member.review_possible_list',[
            'CustomUtils'   => $CustomUtils,
            'exp_appinfos'  => $exp_appinfos,
            'carts'         => $carts,
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
