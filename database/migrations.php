<?php

require_once dirname(__DIR__) . "/config/bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;


Capsule::schema()->create('type_salle', function (Blueprint $table) {
    $table->increments('id');
    $table->string('nom', 100);
});

Capsule::schema()->create('statut_reservation', function (Blueprint $table) {
    $table->increments('id');
    $table->string('nom', 100);
});

Capsule::schema()->create('salles', function (Blueprint $table) {
    $table->increments('id');
    $table->string('nom', 100);
    $table->integer('type_salle_id')->unsigned();
    $table->string('batiment', 100)->nullable();
    $table->integer('capacite')->unsigned();
    $table->boolean('active')->default(true);
    $table->timestamps();

    $table->foreign('type_salle_id')->references('id')->on('type_salle');
});

Capsule::schema()->create('reservations', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('salle_id')->unsigned();
    $table->integer('statut_reservation_id')->unsigned();
    
    $table->string('responsable', 100);
    $table->string('email', 100);
    $table->string('motif', 250)->nullable(); 
    
    $table->dateTime('date_debut');
    $table->dateTime('date_fin');
    $table->timestamps(); 

    $table->foreign('salle_id')->references('id')->on('salles');
    $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation');
});

echo "Migration exécutée avec succès !";