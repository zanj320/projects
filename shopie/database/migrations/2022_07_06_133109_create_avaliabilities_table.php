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
        Schema::create('avaliabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('clothe_id')->constrained('clothes')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity')->default('0');

            $table->unique(['location_id', 'clothe_id']);

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
        Schema::dropIfExists('avaliabilities');
    }
};
