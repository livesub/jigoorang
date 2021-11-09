<?php

namespace App\Http\Controllers\adm\exp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmExpController extends Controller
{
    //뷰 리스트 관련 함수
    public function index(){

       

        return view('adm.exp.exp_list');
    }

    //체험단 신청 뷰 관련 함수
    public function view_create(){
        //신청 뷰로 이동
        //스마트 에디터 경로 설정(쿠키로 설정)
        //$exp_directory = "data/shopitem/editor";
        $exp_directory = "data/exp_list/editor";
        //setcookie('dir', public_path());
        setcookie('directory', $exp_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        return view('adm.exp.exp_create');
    }
}
