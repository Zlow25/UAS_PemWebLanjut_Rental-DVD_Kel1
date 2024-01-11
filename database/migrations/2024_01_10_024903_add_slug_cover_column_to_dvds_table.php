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
        Schema::table('dvds', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('title');
            $table->string('cover', 255)->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dvds', function (Blueprint $table) {
            if (Schema::hasColumn('dvds', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('dvds', 'cover')) {
                $table->dropColumn('cover');
            }
        });
    }
};
