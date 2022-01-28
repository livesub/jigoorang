<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class Withdraw_90day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'withdraw:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'withdraw 90day delete';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //90일이 지난으면 전체 테이블에서 user_id (_del)  붙이고 업데이트(회원 테이블 아이디와 전화 번호도)
        $user_infos = DB::table('users')->where([['user_type', 'Y'], ['withdraw_dispose', 'Y']])->whereRaw("now() > DATE_ADD(withdraw_date, INTERVAL 90 DAY)")->get();
        foreach($user_infos as $user_info){
            $chang_id = $user_info->user_id."_del";
            $chang_phone = $user_info->user_phone."_del";

            //중복 탈퇴 처리
            $user_duplicate = DB::table('users')->where('user_id', $chang_id)->count();

            if($user_duplicate != 0) {
                $chang_id = $user_info->user_id."_del($user_duplicate)";
                $chang_phone = $user_info->user_phone."_del($user_duplicate)";
            }

            $up_user = DB::table('users')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id, 'user_phone' => $chang_phone, 'withdraw_dispose' => 'Y']);    //회원
            $up_shopcarts = DB::table('shopcarts')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //장바구니
            $up_baesongjis = DB::table('baesongjis')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //배송지
            $up_shoppoints = DB::table('shoppoints')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //포인트
            $up_wishs = DB::table('wishs')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //wishs
            $up_shoppostlogs = DB::table('shoppostlogs')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //주문요청 기록
            $up_shoporders = DB::table('shoporders')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //주문서
            $up_shopordertemps = DB::table('shopordertemps')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //결제전주문검증
            $up_exp_application_list = DB::table('exp_application_list')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //체험단 신청 정보
            $up_review_saves = DB::table('review_saves')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //리뷰 저장
            $up_qnas = DB::table('qnas')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //1:1 문의
            $up_qnas = DB::table('qnas')->where('user_id', $user_info->user_id)->update(['user_id' => $chang_id]);    //1:1 문의
        }
//        return 0;
    }
}
