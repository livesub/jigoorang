<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishs', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('user_id')->comment('아이디');
            $table->string('item_code')->comment('상품코드');
            $table->string('wi_ip')->nullable()->comment('아이피');
            $table->timestamps();
            $table->index(['user_id']);
        });

        DB::statement("ALTER TABLE wishs comment 'wish'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishs');
    }
}
