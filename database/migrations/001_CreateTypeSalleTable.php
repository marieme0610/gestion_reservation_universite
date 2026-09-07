<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up(): void
    {
        if (!Capsule::schema()->hasTable('type_salle')) {
            Capsule::schema()->create('type_salle', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nom', 100);
            });
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('type_salle');
    }
};