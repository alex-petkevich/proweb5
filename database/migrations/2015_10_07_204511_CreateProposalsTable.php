<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('proposals', function (Blueprint $table) {
         $table->increments('id');
         $table->string('title');
         $table->integer('category_id');
         $table->string('img');
         $table->text('description');
         $table->timestamp('published_at');
         $table->bigInteger('user_id')->default(0);
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
      Schema::drop('proposals');
   }
}
