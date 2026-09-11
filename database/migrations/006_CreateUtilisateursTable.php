<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->create('utilisateurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100);
            $table->string('email', 150)->unique();
            $table->string('mot_de_passe', 255);
            $table->string('role', 20)->default('responsable'); // 'responsable' ou 'admin'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->dropIfExists('utilisateurs');
    }
};