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
        $user_infos = DB::table('users')->where('user_type', 'Y')->whereRaw("now() > DATE_ADD(withdraw_date, INTERVAL 90 DAY)")->get();
        foreach($user_infos as $user_info){
            var_dump($user_infos->user_id);
            //$update_result = DB::table('')->where([['id', $exp_app_id], ['user_id', Auth::user()->user_id]])->update(['write_yn' => 'y']);
var_dump("process~~~~~~~~~~~~~~~");
        }
//        return 0;
    }
}
