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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('subtitle')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->string('edition')->nullable()->default('1st Edition');
            $table->string('isbn')->nullable();
            $table->date('publication_date');
            $table->string('copyright')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->string('format')->nullable();
            $table->string('paper_height')->nullable();
            $table->string('paper_width')->nullable();
            $table->string('cover_height')->nullable();
            $table->string('cover_width')->nullable();
            $table->integer('pages')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('sku')->unique()->nullable(false);
            $table->string('file_url')->nullable();
            $table->string('print_file_url')->nullable();
            $table->decimal('total_cost', 16, 2)->nullable()->default(0.00);
            $table->decimal('editor', 16, 2)->nullable()->default(0.00);
            $table->decimal('researcher', 16, 2)->nullable()->default(0.00);
            $table->decimal('writer', 16, 2)->nullable()->default(0.00);
            $table->decimal('graphic_designer', 16, 2)->nullable()->default(0.00);
            $table->decimal('layout_designer', 16, 2)->nullable()->default(0.00);
            $table->decimal('photographer', 16, 2)->nullable()->default(0.00);
            $table->decimal('markup_fee', 16, 2)->nullable()->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
