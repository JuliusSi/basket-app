<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('radiation', static function (Blueprint $table) {
            $table->id();
            $table->string('meter')->index();
            $table->string('status')->index();
            $table->float('usvph', 3, 3);
            $table->dateTime('measured_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiation');
    }
};