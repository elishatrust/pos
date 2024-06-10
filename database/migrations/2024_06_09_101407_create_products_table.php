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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('batch')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->float('cost')->nullable();
            $table->float('selling')->nullable();
            $table->integer('qty')->nullable();
            $table->date('mft_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('archive')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
