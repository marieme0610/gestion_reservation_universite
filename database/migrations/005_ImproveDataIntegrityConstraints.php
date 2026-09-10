<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->table('reservations', function (Blueprint $table) {
            $table->dropForeign(['salle_id']);
            $table->dropForeign(['statut_reservation_id']);
        });
        $this->table('reservations', function (Blueprint $table) {
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('restrict');
            $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('restrict');
        });

        $this->table('salles', function (Blueprint $table) {
            $table->dropForeign(['type_salle_id']);
        });
        $this->table('salles', function (Blueprint $table) {
            $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('restrict');
        });

        if (!$this->hasIndex('salles', 'salles_nom_unique')) {
            $this->table('salles', function (Blueprint $table) {
                $table->unique('nom');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasIndex('salles', 'salles_nom_unique')) {
            $this->table('salles', function (Blueprint $table) {
                $table->dropUnique('salles_nom_unique');
            });
        }

        $this->table('salles', function (Blueprint $table) {
            $table->dropForeign(['type_salle_id']);
        });
        $this->table('salles', function (Blueprint $table) {
            $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('cascade');
        });

        $this->table('reservations', function (Blueprint $table) {
            $table->dropForeign(['salle_id']);
            $table->dropForeign(['statut_reservation_id']);
        });
        $this->table('reservations', function (Blueprint $table) {
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('cascade');
        });
    }
};