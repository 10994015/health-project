<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('givebacks', function (Blueprint $table) {
            $table->string('signed_url')->nullable()->unique()->after('game_seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('givebacks', function (Blueprint $table) {
            $table->dropColumn('signed_url');
        });
    }
};
