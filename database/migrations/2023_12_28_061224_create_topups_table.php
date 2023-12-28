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
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('date')->useCurrent();
            $table->string('code');
            $table->double('amount', 10, 2)->default(0);
            $table->integer('point')->default(0);
            $table->enum('status', ['done', 'pending', 'cancel'])->default('pending');
            $table->string('desc')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
