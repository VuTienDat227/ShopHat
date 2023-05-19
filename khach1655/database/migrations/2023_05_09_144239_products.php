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
        //
        Schema::create('Products', function (Blueprint $table) {
            $table->id();
            $table->string('NameProducts');
            $table->text('Details');
            $table->string('Price', );
            $table->integer('Stock');
            $table->integer('Discount');
            $table->integer('CateId');
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
