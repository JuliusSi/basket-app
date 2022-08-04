<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('user', static function (Blueprint $table) {
            $table->integer('sms')->default(2)->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('user', static function (Blueprint $table) {
            $table->dropColumn('sms');
        });
    }
};
