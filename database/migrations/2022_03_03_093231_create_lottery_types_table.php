<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // type(cash,bike,car), image, description,is_Active 
        Schema::create('lottery_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('image');
            $table->longText('description')->nullable();
            $table->boolean('is_Active')->default(1);
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
        Schema::dropIfExists('lottery_types');
    }
}
