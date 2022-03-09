<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElulaCollectionsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elula_collections_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type');
            $table->unsignedBigInteger('collection_id'); 
            $table->foreign('collection_id')->references('id')->on('elula_collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elula_collections_fields');
    }
}
