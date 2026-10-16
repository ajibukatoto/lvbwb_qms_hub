<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interested_parties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('party_type')->default('external');
            $table->text('needs_and_expectations');
            $table->text('qms_relevance')->nullable();
            $table->text('monitoring_method')->nullable();
            $table->string('responsible_person')->nullable();
            $table->date('review_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            $table->index(['party_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interested_parties');
    }
};
