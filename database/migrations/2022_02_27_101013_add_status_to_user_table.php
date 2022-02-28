<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user', static function (Blueprint $table) {
            $table->string('status')->default('user')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user', static function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
