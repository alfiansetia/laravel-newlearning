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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->string('name');
            $table->longText('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('slug');
            $table->integer('price')->default(0);
            $table->string('image_materi')->nullable();
            $table->string('header_materi')->nullable();
            $table->longText('detail_materi')->nullable();
            $table->enum('status', ['reject', 'pending', 'publish'])->default('pending');
            $table->timestamps();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('mentor_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
