
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_reviews', function (Blueprint $table) {
            $table->id();

            $table->string('review_reference')->unique();
            $table->string('title');

            $table->date('meeting_date');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();

            $table->string('venue')->nullable();
            $table->string('chairperson');
            $table->text('attendees')->nullable();

            // Management Review Inputs
            $table->text('agenda')->nullable();
            $table->longText('previous_actions_status')->nullable();
            $table->longText('changes_in_internal_external_issues')->nullable();
            $table->longText('customer_satisfaction')->nullable();
            $table->longText('quality_objectives_performance')->nullable();
            $table->longText('process_performance')->nullable();
            $table->longText('nonconformities_corrective_actions')->nullable();
            $table->longText('audit_results')->nullable();
            $table->longText('risks_opportunities')->nullable();
            $table->longText('resource_adequacy')->nullable();
            $table->longText('improvement_opportunities')->nullable();

            // Management Review Outputs
            $table->longText('decisions')->nullable();
            $table->longText('resource_requirements')->nullable();
            $table->longText('improvement_decisions')->nullable();
            $table->longText('qms_changes')->nullable();
            $table->longText('overall_conclusion')->nullable();

            $table->string('status')->default('Planned');

            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approval_date')->nullable();

            $table->text('remarks')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'meeting_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_reviews');
    }
};
