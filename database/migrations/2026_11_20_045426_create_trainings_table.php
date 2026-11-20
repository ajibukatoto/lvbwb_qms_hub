
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();

            $table->string('training_reference')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('training_type')->default('Internal');
            $table->string('department')->nullable();

            $table->string('trainer');
            $table->string('venue')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->text('participants')->nullable();
            $table->unsignedInteger('number_of_participants')->default(0);

            $table->decimal('training_cost', 15, 2)->nullable();

            $table->string('status')->default('Planned');

            $table->text('training_outcomes')->nullable();
            $table->text('evaluation_results')->nullable();
            $table->text('competence_assessment')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'start_date']);
            $table->index('training_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
