<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->create('type_salle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100);
        });
    }

    public function down(): void
    {
        $this->dropIfExists('type_salle');
    }
};