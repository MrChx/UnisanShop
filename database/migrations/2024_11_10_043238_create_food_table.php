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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail');
            $table->text('about');
            $table->unsignedBigInteger('price');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seller_id')->nullable()->constrained()->cascadeOnDelete(); //nullable untuk mengatur agar user bisa mengisi bagian ini atau tidak
            $table->boolean('is_populer');
            $table->unsignedBigInteger('stock');
            $table->softDeletes(); //agar tidak sepenuhnya terhapus didatabase
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
