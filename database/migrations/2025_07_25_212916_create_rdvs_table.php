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
        Schema::create('rdvs', function (Blueprint $table) {
            $table->id();
            // Infos personnelles
            $table->string('client_nom');
            $table->string('client_prenom')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_tel');

            // Commentaires
            $table->text('commentaires')->nullable();

            // Date de RDV
            $table->dateTime('date_prise_rdv');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rdvs');
    }
};
