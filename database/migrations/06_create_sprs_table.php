<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dp_id')->constrained('departments')->restrictOnDelete();
            $table->foreignId('pr_id')->constrained('problems')->restrictOnDelete();
            $table->foreignId('sender_id')->constrained('users')->restrictOnDelete();
            $table->string('spr_code')->unique();
            $table->string('spr_ucode')->unique();
            $table->string('spr_title');
            $table->longText('spr_description')->nullable();
            $table->json('spr_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprs');
    }
};
