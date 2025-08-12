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
        Schema::create('tag_thread', function (Blueprint $table) {
            $table->primary(['thread_id', 'tag_id']);
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_thread');
    }
};
