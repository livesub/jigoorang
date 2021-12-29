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
            $table->string('sc_zip1')->comment('우편번호 시작');
            $table->string('sc_zip2')->comment('우편번호 끝');
            $table->integer('sc_price')->default(0)->comment('추가배송비');
            $table->timestamps();
            $table->index(['sc_zip1','sc_zip2']);
        });

        DB::statement("ALTER TABLE sendcosts comment '추가 배송비 관리'");

        DB::table('sendcosts')->insert([
            ['sc_name' => '인천광역시 중구', 'sc_zip1' => '22386', 'sc_zip2' => '22388', 'sc_price' => '5000'],
            ['sc_name' => '인천광역시 강화군', 'sc_zip1' => '23004', 'sc_zip2' => '23010', 'sc_price' => '5000'],
            ['sc_name' => '인천광역시 옹진군', 'sc_zip1' => '23101', 'sc_zip2' => '23116', 'sc_price' => '5000'],
        ]);
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
