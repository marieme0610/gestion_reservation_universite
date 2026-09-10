<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        $this->create('salles', function (Blueprint $table) {
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

    public function down(): void
    {
        $this->dropIfExists('salles');
    }
};