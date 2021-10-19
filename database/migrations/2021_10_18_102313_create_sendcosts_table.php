<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendcostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendcosts', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('sc_name')->comment('지역명');
            $table->char('sc_zip1')->length(5)->comment('우편번호 시작');
            $table->char('sc_zip2')->length(5)->comment('우편번호 끝');
            $table->integer('sc_price')->default(0)->comment('추가배송비');
            $table->timestamps();
            $table->index(['sc_zip1']);
        });

        DB::statement("ALTER TABLE sendcosts comment '추가 배송비 관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sendcosts');
    }
}
