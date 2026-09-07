<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up(): void
    {
        if (!Capsule::schema()->hasTable('salles')) {
            Capsule::schema()->create('salles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nom', 100);
                $table->integer('type_salle_id')->unsigned();
                $table->string('batiment', 100)->nullable();
                $table->integer('capacite')->unsigned();
                $table->boolean('active')->default(true);
                $table->timestamps();

                $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('salles');
    }
};