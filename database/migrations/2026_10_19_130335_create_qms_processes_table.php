<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qms_processes', function (Blueprint $table) {
            $table->id();
            $table->string('process_code')->unique();
            $table->string('name');
            $table->string('process_type')->default('operational');
            $table->text('purpose')->nullable();
            $table->text('inputs')->nullable();
            $table->text('activities')->nullable();
            $table->text('outputs')->nullable();
            $table->text('resources')->nullable();
            $table->text('kpis')->nullable();
            $table->text('risks_and_opportunities')->nullable();
            $table->text('interaction_with')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            $table->index(['process_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qms_processes');
    }
};
