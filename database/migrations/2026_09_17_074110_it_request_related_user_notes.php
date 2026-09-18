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
        Schema::create('it_request_related_user_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('it_request_id')
                ->constrained('it_requests', 'IDRequest')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('catatan');

            $table->timestamps();

            $table->index(
                ['it_request_id', 'user_id'],
                'it_request_related_user_notes_request_user_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_request_related_user_notes');
    }
};
