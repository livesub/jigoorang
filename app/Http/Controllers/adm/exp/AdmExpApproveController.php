<?php
#############################################################################
#
#		파일이름		:		AdmExpApproveController.php
#		파일설명		:		관리자페이지 체험단 승인 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 22일
#		최종수정일		:		2021년 11월 22일
#
###########################################################################-->

namespace App\Http\Controllers\adm\exp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크

class AdmExpApproveController extends Controller
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

    public function index(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $exp_id     = $request->input('exp_id');

        $page       = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $exp_info = DB::table('exp_list');
        $exp_last = $exp_info->orderBy('id', 'DESC')->limit(1)->first();
        $exp_lists = $exp_info->orderBy('id', 'DESC')->get();

        $exp_application_info = DB::table('exp_application_list');
        if($exp_id == ''){
            $exp_application_lists = $exp_application_info->where('exp_id', $exp_last->id);
        }else{
            $exp_application_lists = $exp_application_info->where('exp_id', $exp_id);
        }

        $total_record   = 0;
        $total_record   = $exp_application_lists->count(); //총 게시물 수

        $exp_app_lists  = $exp_application_lists->get();

        $virtual_num = $total_record;

        return view('adm.exp.exp_approve_list',[
            'exp_lists'     => $exp_lists,
            'exp_id'        => $exp_id,
            'exp_app_lists' => $exp_app_lists,
            'virtual_num'   => $virtual_num,
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
