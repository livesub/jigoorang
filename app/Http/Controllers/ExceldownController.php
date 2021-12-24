<?php
#############################################################################
#
#		파일이름		:		ExceldownController.php
#		파일설명		:		Excel 다운로드 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 12월 24일
#		최종수정일		:		2021년 12월 24일
#
###########################################################################-->


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\DB;

class ExceldownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_down(Request $request)
    {
        $exp_id = $request->input('exp_id');
        $exp_info = DB::table('exp_list')->select('title')->where('id', $exp_id)->first();
        $exp_app_lists = DB::table('exp_application_list')->where('exp_id', $exp_id)->orderby('id','asc')->get();

        $now_date = date('Ymd', time());
        $file_name = stripslashes($exp_info->title)."_".$now_date.".xls";
        $k = 1;

        header( "Content-type: application/vnd.ms-excel" );
        header( "Content-type: application/vnd.ms-excel; charset=utf-8");
        header( "Content-Disposition: attachment; filename = $file_name" );
        header( "Content-Description: PHP4 Generated Data" );

        $dsp_html = "

        <table>
            <tr>
                <td><b>체험단명 : ".stripslashes($exp_info->title)."_".$now_date."</b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td><b>번호</b></td>
                <td><b>아이디</b></td>
                <td><b>이름</b></td>
                <td><b>휴대폰번호</b></td>
            </tr>
        ";

        foreach($exp_app_lists as $exp_app_list){
            $user_info = DB::table('users')->select('user_phone')->where('user_id', $exp_app_list->user_id)->first();
            $dsp_html .= "
                <tr>
                    <td>$k</td>
                    <td>$exp_app_list->user_id</td>
                    <td>$exp_app_list->user_name</td>
                    <td style=mso-number-format:'\@'>$user_info->user_phone</td>
                </tr>

                <tr>
                    <td>평가단 참여이유</td>
                    <td colspan='3'>$exp_app_list->reason_memo</td>
                </tr>
                <tr>
                    <td>배송지 수령인</td>
                    <td colspan='3'>$exp_app_list->ad_name</td>
                </tr>
                <tr>
                    <td>배송지 수령인 휴대폰번호</td>
                    <td colspan='3' style=mso-number-format:'\@'>$exp_app_list->ad_hp</td>
                </tr>
                <tr>
                    <td>배송지</td>
                    <td colspan='3' style=mso-number-format:'\@'>(".$exp_app_list->ad_zip1.") ".$exp_app_list->ad_addr1." ".$exp_app_list->ad_addr2." ".$exp_app_list->ad_addr3."</td>
                </tr>
                <tr>
                    <td>배송메모</td>
                    <td colspan='3'>$exp_app_list->shipping_memo</td>
                </tr>
                <tr>
                    <td style='height:30px;' colspan='4'></td>
                </tr>
            ";
            $k++;
        }

        $dsp_html .= "
        </table>
        ";


        echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
        echo $dsp_html;

/*
        $sql = "select * from tblName order by reg_date desc";
        $result = mysql_query($sql);

        // 테이블 상단 만들기
        $EXCEL_STR = "
        <table border='1'>
        <tr>
           <td>번호</td>
           <td>코드</td>
           <td>내용</td>
        </tr>";

        while($row = mysql_fetch_array($result)) {
           $EXCEL_STR .= "
           <tr>
               <td>".$row['idx']."</td>
               <td>".$row['code']."</td>
               <td>".$row['contents']."</td>
           </tr>
           ";
        }

        $EXCEL_STR .= "</table>";

        echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
        echo $EXCEL_STR;
*/
    }

}
