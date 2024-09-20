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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prénom');
            $table->tinyInteger('role')->default(0); // Adding the role column with a default value of 0 (prof)
            $table->string('email')->unique();
            $table->string('password');
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->foreignId('laboratoire_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipe_id')->constrained()->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
