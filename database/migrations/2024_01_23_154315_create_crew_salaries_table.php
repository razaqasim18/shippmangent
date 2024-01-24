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
        Schema::create('crew_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crew_id');
            $table->foreign('crew_id')->references('id')->on('crews')->onDelete('cascade');
            $table->decimal('january', 10, 2)->nullable();
            $table->decimal('february', 10, 2)->nullable();
            $table->decimal('march', 10, 2)->nullable();
            $table->decimal('april', 10, 2)->nullable();
            $table->decimal('may', 10, 2)->nullable();
            $table->decimal('june', 10, 2)->nullable();
            $table->decimal('july', 10, 2)->nullable();
            $table->decimal('august', 10, 2)->nullable();
            $table->decimal('september', 10, 2)->nullable();
            $table->decimal('october', 10, 2)->nullable();
            $table->decimal('november', 10, 2)->nullable();
            $table->decimal('december', 10, 2)->nullable();
            $table->year('year');
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crew_salaries');
    }
};
