<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up(): void
    {
        if (!Capsule::schema()->hasTable('statut_reservation')) {
            Capsule::schema()->create('statut_reservation', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nom', 100);
            });
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('statut_reservation');
    }
};