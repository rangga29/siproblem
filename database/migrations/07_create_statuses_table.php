<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spr_id')->constrained('sprs')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('st_ucode')->unique();
            $table->longText('st_description')->nullable();
            $table->json('st_images')->nullable();
            $table->enum('st_name',['Terkirim','Diproses','Dibatalkan','Selesai'])->default('Terkirim');
            $table->boolean('st_status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
