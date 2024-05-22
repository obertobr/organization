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
        Schema::create('item_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_tag');
            $table->unsignedBigInteger('fk_item');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('fk_tag')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('fk_item')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_tags');
    }
};
