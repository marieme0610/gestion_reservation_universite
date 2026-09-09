<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;


return new class {
    public function up(): void
    {
        Capsule::schema()->table('reservations', function (Blueprint $table) {
            $table->dropForeign(['salle_id']);
            $table->dropForeign(['statut_reservation_id']);
        });
        Capsule::schema()->table('reservations', function (Blueprint $table) {
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('restrict');
            $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('restrict');
        });

        Capsule::schema()->table('salles', function (Blueprint $table) {
            $table->dropForeign(['type_salle_id']);
        });
        Capsule::schema()->table('salles', function (Blueprint $table) {
            $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('restrict');
        });

        if (!$this->hasIndex('salles', 'salles_nom_unique')) {
            Capsule::schema()->table('salles', function (Blueprint $table) {
                $table->unique('nom');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasIndex('salles', 'salles_nom_unique')) {
            Capsule::schema()->table('salles', function (Blueprint $table) {
                $table->dropUnique('salles_nom_unique');
            });
        }

        Capsule::schema()->table('salles', function (Blueprint $table) {
            $table->dropForeign(['type_salle_id']);
        });
        Capsule::schema()->table('salles', function (Blueprint $table) {
            $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('cascade');
        });

        Capsule::schema()->table('reservations', function (Blueprint $table) {
            $table->dropForeign(['salle_id']);
            $table->dropForeign(['statut_reservation_id']);
        });
        Capsule::schema()->table('reservations', function (Blueprint $table) {
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('cascade');
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $connection = Capsule::connection();
        $result = $connection->select(
            'SELECT COUNT(1) AS aggregate FROM information_schema.statistics
             WHERE table_schema = ? AND table_name = ? AND index_name = ?',
            [$connection->getDatabaseName(), $table, $indexName]
        );

        return ((int) ($result[0]->aggregate ?? 0)) > 0;
    }
};