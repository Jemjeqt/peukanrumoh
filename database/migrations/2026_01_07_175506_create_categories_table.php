<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default categories
        DB::table('categories')->insert([
            ['name' => 'Sayuran', 'icon' => '🥬', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Buah', 'icon' => '🍎', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bumbu', 'icon' => '🧄', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Protein', 'icon' => '🥚', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sembako', 'icon' => '🍚', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daging', 'icon' => '🥩', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ikan', 'icon' => '🐟', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kebutuhan Harian', 'icon' => '🧴', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
