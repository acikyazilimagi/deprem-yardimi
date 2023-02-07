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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('district');
            $table->string('street');
            $table->string('street2');
            $table->string('apartment');
            $table->string('apartment_no');
            $table->string('apartment_floor')->comment('Kazazedenin bulunduğu kat numarası');
            $table->string('phone');
            $table->string('address');
            $table->string('fullname');
            $table->string('source');
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
        Schema::dropIfExists('data');
    }
};
