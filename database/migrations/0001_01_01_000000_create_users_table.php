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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('role')->default(1);
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('archive')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('manager')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('show_status')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('archive')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('archive')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->rememberToken();
            $table->timestamps();
        });



        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
