<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start'); // Ensure this is of type date
            $table->date('end');   // Ensure this is of type date
            $table->string('nama_ruang')->nullable();
            $table->string('baju')->nullable();
            $table->timestamps();
        });                         
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
