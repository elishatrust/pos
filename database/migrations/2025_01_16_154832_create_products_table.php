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
            $table->string('bar_code')->nullable();
            $table->string('barcode')->nullable();
            $table->string('product')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0); // Price with up to 2 decimal places
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->integer('stock')->default(0);
            $table->unsignedBigInteger('category_id'); // Foreign key for categories
            $table->boolean('status')->default(0); // 1 for active, 0 for inactive
            $table->unsignedBigInteger('created_by')->nullable(); // User who created the record
            $table->unsignedBigInteger('updated_by')->nullable(); // User who last updated the record
            $table->timestamps(); // Created at and updated at

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
