<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rubriques', function (Blueprint $table) {
            $table->id();
            $table->string('titre'); // ex : "Essentiel", "Pro", "Premium 24/7"

            // Champs correspondant aux lignes de ton tableau
            $table->string('plage_support')->nullable();
            $table->string('tti_ttr')->nullable();
            $table->string('preventif')->nullable();
            $table->string('pieces_conso')->nullable();
            $table->string('reporting')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubriques');
    }
};
