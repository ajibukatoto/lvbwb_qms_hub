<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qms_scopes', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('scope_statement');

            $table->text('organizational_units')->nullable();
            $table->text('locations')->nullable();
            $table->text('services')->nullable();
            $table->text('exclusions')->nullable();

            $table->enum('status', [
                'draft',
                'under_review',
                'approved',
                'superseded',
            ])->default('draft');

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

            $table->timestamps();

            $table->index('status');
            $table->index('review_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qms_scopes');
    }
};
