
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_audits', function (Blueprint $table) {
            $table->id();

            $table->string('audit_reference')->unique();
            $table->string('title');
            $table->string('audit_type')->default('Process Audit');

            $table->text('objective');
            $table->text('scope');
            $table->text('criteria');

            $table->string('department_or_process');
            $table->string('lead_auditor');
            $table->text('audit_team')->nullable();

            $table->date('planned_start_date');
            $table->date('planned_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();

            $table->string('status')->default('Planned');
            $table->text('summary_of_results')->nullable();
            $table->text('report_location')->nullable();
            $table->date('report_date')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'planned_start_date']);
            $table->index('department_or_process');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_audits');
    }
};
