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
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('brand');
            $table->string('slug');
            $table->text('description');
            $table->decimal('price');
            $table->boolean('status')->default(1);
            $table->integer('qty');
            $table->string('color');
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('depth');
            $table->decimal('weight');
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
