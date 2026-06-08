<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('model');
            $table->string('category');
            $table->string('downpayment')->default(0);
            $table->enum('status',['pending','ongoing','completed'])->default('pending');
            $table->string('ticket_number');
            $table->decimal('estimated_cost');
            $table->decimal('actual_cost')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
