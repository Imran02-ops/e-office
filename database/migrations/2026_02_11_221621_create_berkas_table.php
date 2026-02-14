<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_berkas');
            $table->string('file_path');
            $table->enum('status', ['dikerjakan', 'selesai'])->default('dikerjakan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
