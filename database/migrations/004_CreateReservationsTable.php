<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salle_id')->unsigned();
            $table->integer('statut_reservation_id')->unsigned();

            $table->string('responsable', 100);
            $table->string('email', 100);
            $table->string('motif', 250)->nullable();

            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->timestamps();

            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        $this->dropIfExists('reservations');
    }
};