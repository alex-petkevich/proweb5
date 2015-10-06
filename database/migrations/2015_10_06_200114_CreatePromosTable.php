<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('promos', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name')->unique();
         $table->integer('category_id');
         $table->string('img');
         $table->string('link');
         $table->bigInteger('shows');
         $table->bigInteger('clicks');
         $table->text('description');
         $table->boolean('active')->default(true);
         $table->timestamps();
         $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::drop('promos');
   }
}
