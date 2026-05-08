<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('position')->unique();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        DB::table('process_steps')->insert([
            [
                'position' => 1,
                'title' => 'Unggah Dokumen',
                'description' => 'Lengkapi berkas administrasi sesuai persyaratan yang ditentukan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 2,
                'title' => 'Verifikasi Data',
                'description' => 'Tim admin akan memeriksa validitas dokumen yang telah dikirimkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 3,
                'title' => 'Selesai Terintegrasi',
                'description' => 'Dokumen berhasil divalidasi dan siap digunakan dalam sistem.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_steps');
    }
};
