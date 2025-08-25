<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('order')->default(0);
            $table->json('extras')->nullable(); // contenu additionnel flexible
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subsections');
    }
};
