<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('returns', function (Blueprint $table) {
            // For replacement: second kurir to deliver replacement
            $table->foreignId('replacement_kurir_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('replacement_shipped_at')->nullable();
            $table->timestamp('replacement_delivered_at')->nullable();
            // For refund: confirmation
            $table->timestamp('refund_sent_at')->nullable();
            $table->string('refund_proof')->nullable(); // bukti transfer
        });
    }

    public function down(): void
    {
        Schema::table('returns', function (Blueprint $table) {
            $table->dropForeign(['replacement_kurir_id']);
            $table->dropColumn([
                'replacement_kurir_id',
                'replacement_shipped_at',
                'replacement_delivered_at',
                'refund_sent_at',
                'refund_proof',
            ]);
        });
    }
};
