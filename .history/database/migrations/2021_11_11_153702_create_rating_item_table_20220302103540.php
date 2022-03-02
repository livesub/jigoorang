<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_item', function (Blueprint $table) {
            $table->id();
            $table->string('sca_id')->comment('카테고리 아이디');
            $table->string('item_name1')->comment('정량 평가 항목 1');
            $table->string('item_name2')->comment('정량 평가 항목 2');
            $table->string('item_name3')->comment('정량 평가 항목 3');
            $table->string('item_name4')->comment('정량 평가 항목 4');
            $table->string('item_name5')->comment('정량 평가 항목 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_item');
    }
}
