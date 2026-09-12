<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        if ($this->hasForeign('reservations', 'reservations_salle_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->dropForeign(['salle_id']);
            });
        }
        if ($this->hasForeign('reservations', 'reservations_statut_reservation_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->dropForeign(['statut_reservation_id']);
            });
        }

        if (!$this->hasForeign('reservations', 'reservations_salle_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->foreign('salle_id')->references('id')->on('salles')->onDelete('restrict');
            });
        }
        if (!$this->hasForeign('reservations', 'reservations_statut_reservation_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('restrict');
            });
        }

        if ($this->hasForeign('salles', 'salles_type_salle_id_foreign')) {
            $this->table('salles', function (Blueprint $table) {
                $table->dropForeign(['type_salle_id']);
            });
        }
        if (!$this->hasForeign('salles', 'salles_type_salle_id_foreign')) {
            $this->table('salles', function (Blueprint $table) {
                $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('restrict');
            });
        }

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

        if ($this->hasForeign('salles', 'salles_type_salle_id_foreign')) {
            $this->table('salles', function (Blueprint $table) {
                $table->dropForeign(['type_salle_id']);
            });
        }
        if (!$this->hasForeign('salles', 'salles_type_salle_id_foreign')) {
            $this->table('salles', function (Blueprint $table) {
                $table->foreign('type_salle_id')->references('id')->on('type_salle')->onDelete('cascade');
            });
        }

        if ($this->hasForeign('reservations', 'reservations_salle_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->dropForeign(['salle_id']);
            });
        }
        if ($this->hasForeign('reservations', 'reservations_statut_reservation_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->dropForeign(['statut_reservation_id']);
            });
        }

        if (!$this->hasForeign('reservations', 'reservations_salle_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            });
        }
        if (!$this->hasForeign('reservations', 'reservations_statut_reservation_id_foreign')) {
            $this->table('reservations', function (Blueprint $table) {
                $table->foreign('statut_reservation_id')->references('id')->on('statut_reservation')->onDelete('cascade');
            });
        }
    }
};