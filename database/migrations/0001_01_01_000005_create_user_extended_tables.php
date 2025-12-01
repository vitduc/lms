<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // User profiles
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('profession')->nullable();
            $table->text('social_links')->nullable(); // JSON
            $table->boolean('is_instructor')->default(false);
            $table->text('instructor_bio')->nullable();
            $table->string('instructor_title')->nullable();
            $table->integer('total_students')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->timestamps();

            $table->index('is_instructor');
        });

        // User audit logs
        Schema::create('user_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action'); // login, logout, create, update, delete, etc.
            $table->string('model')->nullable(); // Course, Quiz, Payment, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('changes')->nullable(); // Store old/new values
            $table->text('description')->nullable();
            $table->string('status')->default('success'); // success, failed
            $table->timestamps();

            $table->index('user_id');
            $table->index('action');
            $table->index('model');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_audit_logs');
        Schema::dropIfExists('user_profiles');
    }
};
