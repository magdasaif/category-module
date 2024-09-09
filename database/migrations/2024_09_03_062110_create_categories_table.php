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
        Schema::create('categories', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->enum('type', ['product', 'service'])->default('product');
            $table->text('description_ar');
            $table->text('description_en');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
