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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id');
            $table->string('name', 50);
            $table->string('rank', 20);
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('total_salary', 10, 2)->nullable();
            $table->decimal('withdraw_salary', 10, 2)->nullable();
            $table->decimal('remaining_salary', 10, 2)->nullable();
            $table->date('join_date');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('image')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes(); // Add soft deletes columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
