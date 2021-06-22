<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Stmt\Enum_;

class CreateElementOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('element_id');
            $table->unsignedBigInteger('order_id');
            $table->string('type', 30);
            $table->string('colors', 100);
            $table->enum('place', [
                'pecho',
                'espalda',
                'frente',
                'manga',
                'gorra',
                'pierna'
            ]);
            $table->text("description");

            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('element_order');
    }
}
