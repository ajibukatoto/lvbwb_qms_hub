
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_review_actions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('management_review_id')
                ->constrained('management_reviews')
                ->cascadeOnDelete();

            $table->string('action_reference')->nullable()->unique();

            $table->string('action_title');
            $table->longText('action_description')->nullable();

            $table->string('responsible_person');
            $table->string('responsible_department')->nullable();

            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();

            $table->string('status')->default('Open');

            $table->longText('evidence_of_completion')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index(['status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_review_actions');
    }
};
