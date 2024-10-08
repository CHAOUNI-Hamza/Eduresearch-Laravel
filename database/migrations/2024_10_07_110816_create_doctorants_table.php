<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctorants', function (Blueprint $table) {
            $table->id();
            $table->string('CIN')->unique();
            $table->string('APOGEE')->unique();
            $table->string('NOM');
            $table->string('PRENOM');
            $table->date('date_inscription');
            $table->string('nationalite')->default('marocaine');
            $table->date('date_soutenance')->nullable(); // nullable
            $table->text('sujet_these');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctorants');
    }
};
