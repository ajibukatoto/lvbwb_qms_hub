
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_opportunities', function (Blueprint $table) {
            $table->id();

            $table->string('reference_code')->unique();
            $table->string('title');
            $table->string('type')->default('risk');
            $table->string('category')->default('operational');

            $table->text('description');
            $table->text('potential_effect')->nullable();

            $table->unsignedTinyInteger('likelihood')->default(3);
            $table->unsignedTinyInteger('impact')->default(3);
            $table->unsignedSmallInteger('risk_score')->default(9);

            $table->text('existing_controls')->nullable();
            $table->text('planned_actions')->nullable();

            $table->string('responsible_person')->nullable();
            $table->date('target_date')->nullable();

            $table->string('status')->default('identified');
            $table->text('review_notes')->nullable();
            $table->date('last_reviewed_at')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index(['risk_score', 'target_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_opportunities');
    }
};
