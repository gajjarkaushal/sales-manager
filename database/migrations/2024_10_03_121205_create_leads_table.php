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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique(); // Lead's email, unique
            $table->string('contactno')->nullable(); // Contact number (nullable)
            $table->string('company')->nullable(); // Company name (nullable)
            $table->string('website')->nullable(); // Website (nullable)
            $table->text('message')->nullable(); // Lead's message or inquiry (nullable)
            $table->string('file_attachment')->nullable(); // File attachment (nullable, store file path or filename)

            // Adding role_id as a foreign key
            $table->unsignedBigInteger('role_id')->nullable(); // Foreign key to roles
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Drop foreign key before dropping the column
            $table->dropForeign(['role_id']);
        });
        
        Schema::dropIfExists('leads');
    }
};
