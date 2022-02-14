<?php
#############################################################################
#
#		파일이름		:		CompanyController.php
#		파일설명		:		지구랭 소개
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 26일
#		최종수정일		:		2022년 01월 26일
#
###########################################################################-->

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.company',[
        ]);
    }
}
