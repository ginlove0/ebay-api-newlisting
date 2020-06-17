<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemComparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_compares', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigIncrements('itemid');
            $table->string('title', 255);
            $table->string('item_condition',255);
            $table->decimal('price', 19, 2);
            $table->string('start_time');
            $table->string('end_time');
            $table->string('from_site');
            $table->decimal('shipping_cost', 19, 2);
            $table->string('description');
            $table->string('picture')->nullable(true);
            $table->boolean('has_seen');
            $table->string('seller');
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
        Schema::dropIfExists('item_compares');
    }
}
