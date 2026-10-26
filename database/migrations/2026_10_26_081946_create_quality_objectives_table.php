
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_objectives', function (Blueprint $table) {
            $table->id();

            $table->string('objective_code')->unique();
            $table->string('title');
            $table->text('description');

            $table->string('related_process')->nullable();
            $table->string('kpi_name');
            $table->string('measurement_method')->nullable();
            $table->string('unit_of_measure')->nullable();

            $table->decimal('baseline_value', 12, 2)->nullable();
            $table->decimal('target_value', 12, 2);
            $table->decimal('actual_value', 12, 2)->nullable();

            $table->string('measurement_frequency')->default('Quarterly');
            $table->string('responsible_person')->nullable();

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('last_review_date')->nullable();

            $table->unsignedTinyInteger('progress_percentage')->default(0);
            $table->string('status')->default('Draft');
            $table->text('review_notes')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_objectives');
    }
};
