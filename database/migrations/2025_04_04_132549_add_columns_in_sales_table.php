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
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_item')->default(0);
            $table->decimal('total_price')->default(0);
            $table->decimal('discount')->default(0);
            $table->enum('accept',['yes','no'])->default('yes');
            $table->boolean('status')->default(0); 
            $table->boolean('archive')->default(0); 
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
};
