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
        Schema::create('transections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id');
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->text('detail')->nullable();
            $table->tinyInteger('status')->comment("0 debit,1 credit");
            $table->tinyInteger('expense_type')->comment("1 office expense,1 ship office expense,3 salary expense");
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transections');
    }
};
