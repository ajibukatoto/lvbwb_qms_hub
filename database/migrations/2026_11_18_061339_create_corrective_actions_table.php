
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();

            $table->string('capa_reference')->unique();

            $table->foreignId('nonconformity_id')
                ->nullable()
                ->constrained('nonconformities')
                ->nullOnDelete();

            $table->string('title');
            $table->text('root_cause');
            $table->text('correction')->nullable();
            $table->text('corrective_action');
            $table->text('preventive_action')->nullable();

            $table->string('responsible_person');
            $table->date('planned_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();

            $table->string('status')->default('Open');

            $table->text('verification_method')->nullable();
            $table->text('verification_results')->nullable();
            $table->string('effectiveness')->nullable();
            $table->date('verification_date')->nullable();
            $table->string('verified_by')->nullable();

            $table->text('remarks')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'planned_completion_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};
