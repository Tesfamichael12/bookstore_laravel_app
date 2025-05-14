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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Corresponds to INT AUTO_INCREMENT PRIMARY KEY
            $table->string('title'); // Corresponds to VARCHAR(255) NOT NULL
            $table->string('author'); // Corresponds to VARCHAR(255) NOT NULL
            $table->string('genre', 100)->nullable(); // Corresponds to VARCHAR(100), nullable
            $table->string('cover_photo')->nullable(); // Corresponds to VARCHAR(255), nullable
            $table->integer('published_year')->nullable(); // Changed from year() to integer()
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
