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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->enum('role',['super-admin','admin','sub-admin'])->default('super-admin');
            $table->enum('status',['ACTIVE','BLOCKED','DELETED'])->default('ACTIVE');
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
