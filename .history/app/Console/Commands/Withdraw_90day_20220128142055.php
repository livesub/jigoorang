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
        $user_infos = DB::table('users')->where('user_type', 'Y')->get();
        dd($user_infos);
        return 0;
    }
}
