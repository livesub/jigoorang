<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('b_name')->comment('제목');
            $table->enum('b_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->string('b_link')->comment('링크경로');
            $table->enum('b_target', ['N', 'Y'])->length(2)->default('N')->comment('타겟 : N=>현재창,Y=>새창');
            $table->text('b_pc_img')->nullable()->comment('pc 이미지(원본@@썸네일1@@썸네일2..)');
            $table->string('b_pc_ori_img')->nullable()->comment('pc 이미지파일이름');
            $table->text('b_mobile_img')->nullable()->comment('mobile 이미지(원본@@썸네일1@@썸네일2..)');
            $table->string('b_mobile_ori_img')->nullable()->comment('mobile 이미지파일이름');
            $table->enum('b_type', ['1', '2'])->length(2)->default('1')->comment('분류 : 1=>상단,2=>하단');
            $table->timestamps();
            $table->index(['b_display','b_type']);
        });

        DB::statement("ALTER TABLE banners comment '배너관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
