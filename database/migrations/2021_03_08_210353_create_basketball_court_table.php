<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketballCourtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basketball_court', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_code_id')->constrained('place_code');
            $table->string('name');
            $table->string('description');
            $table->string('city');
            $table->string('address');
            $table->string('image_path')->default('img/no-image.png');
            $table->timestamps();
            $table->index('city');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basketball_court');
    }
}
