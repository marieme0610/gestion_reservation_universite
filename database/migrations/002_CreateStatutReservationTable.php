<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->create('statut_reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100);
        });
    }

    public function down(): void
    {
        $this->dropIfExists('statut_reservation');
    }
};