<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up(): void
      {
          Schema::create('books', function (Blueprint $table) {
              $table->id();
              $table->string('title');
              $table->string('author');
              $table->string('publisher')->nullable();
              $table->integer('year')->nullable();
              $table->string('isbn')->nullable();
              $table->enum('status', ['available', 'borrowed'])->default('available');
              $table->softDeletes();
              $table->timestamps();
          });
      }

      public function down(): void
      {
          Schema::dropIfExists('books');
      }
  };