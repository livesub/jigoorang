<?php

namespace App\Http\Controllers\exp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//models 추가
use App\Models\ExpList;
use App\Models\ExpApplicationList;
use App\Models\baesongjis;
//서비스 클래스 추가
use App\Services\ExpService;
use Illuminate\Support\Facades\DB;

class expController extends Controller
{

    public function __construct(ExpService $expService, ExpList $expList, baesongjis $baesongjis, ExpApplicationList $expApplicationList)
    {
        $this->expService = $expService;
        $this->expList = $expList;
        $this->baesongjis = $baesongjis;
        $this->expApplicationList = $expApplicationList;
    }

    //체험단 리스트 뷰 관련 함수 선언
    public function index(Request $request){


        $page = $request->input('page');
        //$page = 0;
        //$expAllLists = $this->expList->latest()->paginate(1);

        return $this->expService->set_page($page, 1);
        //return "체험단 리스트 뷰입니다.";

    }

    //체험단 상세보기 뷰 이동 관련 함수
    public function view_detail($id){

        $result = $this->expService->detail_view($id);

        if(!empty($result)){
            return view('exp.exp_detail', compact('result'));
        }else{
            return redirect()->route('exp.list')->with('alert_messages', "잘못된 정보입니다.");
        }

    }

    //체험단 신청 폼 뷰 이동 관련 함수
    public function view_form($id){

        $exp_list = DB::table('exp_list')->select('exp_date_end')->where('id', $id)->first();
        if(date('Y-m-d', time()) > $exp_list->exp_date_end){
            return redirect()->route('exp.list')->with('alert_messages', "모집 기간이 종료 되었습니다.");
        }

        //중복 확인
        //$overlab = $this->expApplicationList->whereUser_id(auth()->user()->id)->whereExp_id($id)->first();
        $overlab = $this->expApplicationList->whereUser_id(auth()->user()->user_id)->whereExp_id($id)->first();



        if(!empty($overlab) || $overlab != null || $overlab != ""){
            return redirect()->route('exp.list.detail', $id)->with('alert_messages', "본 평가단을 이미 신청하셨습니다.");
        }

        $result = $this->expService->detail_view($id);

        $user_id = auth()->user()->user_id;

        $address = $this->baesongjis->where('user_id', $user_id)->where('ad_default', 1)->first();

        if(empty($address)){

            $address = $this->baesongjis->where('user_id', $user_id)->first();

        }
        //dd($address);
        if(!empty($result)){

            return view('exp.exp_form', compact('address', 'id', 'result'));

        }else{

            return redirect()->route('exp.list')->with('alert_messages', "잘못된 정보입니다.");
        }
    }

    //체험단 신청 폼 db저장 함수
    public function exp_form_save(Request $request){

        $result = $this->expService->exp_form_save($request);

        if($result){
            return redirect()->route('exp.list')->with('alert_messages', '평가단 신청이 완료되었습니다.');
        }else{
            return redirect()->route('exp.list')->with('alert_messages', '잘못된 접근입니다.!');
        }

    }
}
