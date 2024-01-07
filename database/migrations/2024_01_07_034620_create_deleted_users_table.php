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
        Schema::create('deleted_users', function (Blueprint $table) {
            $table->id();
            $table->string('userID', 50);
            $table->string('name');
            $table->string('email');
            $table->text('profile_img')->nullable();
            $table->string('role')->default('user');
            $table->string('mode')->default('light');
            $table->integer('phone')->nullable();
            $table->string('status')->default('active');
            $table->integer('suspicious_count')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_user');
    }
};
