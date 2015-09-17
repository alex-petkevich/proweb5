<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pages', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('parent_id')->default(0);
         $table->string('name')->unique();
         $table->string('title');
         $table->string('meta_title');
         $table->text('description');
         $table->text('meta_description');
         $table->text('meta_keywords');
         $table->text('only_for_roles');
         $table->boolean('active')->default(true);
         $table->boolean('show_title')->default(true);
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
      Schema::drop('pages');
   }
}
