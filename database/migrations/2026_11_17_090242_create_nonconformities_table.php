<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nonconformities', function (Blueprint $table) {
            $table->id();

            $table->string('ncr_reference')->unique();

            $table->foreignId('audit_finding_id')
                ->nullable()
                ->constrained('audit_findings')
                ->nullOnDelete();

            $table->string('title');

            $table->string('source')->default('Internal Audit');

            $table->string('department_or_process');

            $table->string('severity')->default('Minor');

            $table->string('iso_clause')->nullable();

            $table->date('identified_date');

            $table->text('nonconformity_description');

            $table->text('objective_evidence')->nullable();

            $table->text('immediate_correction')->nullable();

            $table->string('responsible_person')->nullable();

            $table->date('target_resolution_date')->nullable();

            $table->string('status')->default('Open');

            $table->text('review_notes')->nullable();

            $table->date('closed_date')->nullable();

            $table->string('verified_by')->nullable();

            $table->text('closure_evidence')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['severity', 'status']);
            $table->index(['source', 'identified_date']);
            $table->index('target_resolution_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nonconformities');
    }
};
