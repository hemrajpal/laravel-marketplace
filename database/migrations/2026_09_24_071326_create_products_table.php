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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Product owner
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Category
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('state_id')
            ->constrained()
            ->restrictOnDelete();

            $table->foreignId('city_id')
            ->constrained()
            ->restrictOnDelete();

            // Product / Service
            $table->enum('type', [
                'product',
                'service',
            ]);

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('detail');

            // Location
            $table->string('country', 100);
            $table->string('area', 150);

            // Price
            $table->decimal('price', 12, 2);

            // Publishing status
            $table->enum('status', [
                'draft',
                'published',
            ])->default('published');

            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
