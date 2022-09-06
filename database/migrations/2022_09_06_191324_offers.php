<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer("external_id")->unique();
            $table->string("mark");
            $table->string("model");
            $table->string("generation");
            $table->string("year");
            $table->string("run");
            $table->string("color");
            $table->string("body_type");
            $table->string("engine_type");
            $table->string("transmission");
            $table->string("gear_type");
            $table->integer("generation_id");
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
        //
    }
};
