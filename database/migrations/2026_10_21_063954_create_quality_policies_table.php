<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_policies', function (Blueprint $table) {
            $table->id();

            $table->string('policy_code')->unique();
            $table->string('title');
            $table->longText('policy_statement');

            $table->string('version')->default('1.0');

            $table->string('status')->default('draft');

            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable();

            $table->foreignId('prepared_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('approval_comments')->nullable();

            $table->string('document_file')->nullable();

            $table->timestamps();

            $table->index(['status', 'review_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_policies');
    }
};
