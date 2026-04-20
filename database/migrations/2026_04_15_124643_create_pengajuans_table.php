<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->string('nama');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('jenis_surat');
            $table->text('keperluan');
            $table->string('file_ktp');      // path file
            $table->string('file_kk');       // path file
            $table->string('file_surat_rt'); // path file
            $table->enum('status', ['Pending', 'Diproses', 'Selesai', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};