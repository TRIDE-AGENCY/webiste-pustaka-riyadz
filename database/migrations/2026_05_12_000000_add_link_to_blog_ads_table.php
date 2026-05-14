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
        if (Schema::hasColumn('blog_ads', 'link')) {
            return;
        }

        Schema::table('blog_ads', function (Blueprint $table) {
            $table->text('link')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('blog_ads', 'link')) {
            return;
        }

        Schema::table('blog_ads', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
