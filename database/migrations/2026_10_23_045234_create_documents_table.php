<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->string('document_code')->unique();
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();

            // File path and original file name
            $table->string('file_path')->nullable();
            $table->string('original_file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // Document version and workflow
            $table->string('version')->default('1.0');

            $table->string('status')->default('draft');

            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable();

            // Responsible users
            $table->foreignId('prepared_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('approval_comments')->nullable();

            $table->timestamps();

            $table->index(['category', 'status']);
            $table->index('review_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
