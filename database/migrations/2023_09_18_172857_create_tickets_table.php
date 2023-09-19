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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('priority')->nullable();
            $table->string('status')->default('open');
            $table->json('files')->nullable()->default([]);
            $table->unsignedBigInteger('agent_id');
            $table->timestamps();
            $table->json('labels')->nullable()->default([]);
            $table->json('categories')->nullable()->default([]);

            $table->foreign('agent_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
