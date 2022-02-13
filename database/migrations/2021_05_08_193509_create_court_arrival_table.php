<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtArrivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_arrival', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->cascadeOnDelete();
            $table->foreignId('court_id')->constrained('basketball_court')->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->softDeletes();
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
        Schema::dropIfExists('court_arrival');
    }
}
