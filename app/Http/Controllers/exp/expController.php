<?php

namespace App\Http\Controllers\exp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//models 추가
use App\Models\ExpList;
//서비스 클래스 추가
use App\Services\ExpService;

class expController extends Controller
{

    public function __construct(ExpService $expService, ExpList $expList)
    {
        $this->expService = $expService;
        $this->expList = $expList;
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

        $result = $this->expService->detail_view($id);

        if(!empty($result)){

            return view('exp.exp_form');

        }else{

            return redirect()->route('exp.list')->with('alert_messages', "잘못된 정보입니다.");
        }
    }
}
