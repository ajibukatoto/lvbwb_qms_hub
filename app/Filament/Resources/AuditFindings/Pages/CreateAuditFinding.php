
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_findings', function (Blueprint $table) {
            $table->id();

            $table->string('finding_reference')->unique();

            $table->foreignId('internal_audit_id')
                ->constrained('internal_audits')
                ->cascadeOnDelete();

            $table->string('finding_title');

            $table->string('finding_type')->default('Observation');

            $table->string('iso_clause')->nullable();

            $table->text('finding_description');

            $table->text('objective_evidence')->nullable();

            $table->text('requirement')->nullable();

            $table->text('corrective_action_required')->nullable();

            $table->string('responsible_person')->nullable();

            $table->date('target_closure_date')->nullable();

            $table->string('status')->default('Open');

            $table->text('root_cause')->nullable();

            $table->text('closure_evidence')->nullable();

            $table->date('closed_at')->nullable();

            $table->string('verified_by')->nullable();

            $table->text('verification_notes')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['finding_type', 'status']);
            $table->index('target_closure_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_findings');
    }
};
