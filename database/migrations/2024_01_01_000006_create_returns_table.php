<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('kurir_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reason');
            $table->string('evidence')->nullable(); // photo proof
            $table->enum('type', ['replacement', 'refund'])->default('refund');
            $table->enum('status', ['pending', 'approved', 'rejected', 'pickup', 'delivering', 'received', 'replacement_shipping', 'replacement_delivered', 'refund_sent', 'refund_confirmed', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
