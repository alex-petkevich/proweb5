<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration
{

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('blog_categories', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name')->unique();
         $table->string('title');
         $table->string('meta_title');
         $table->text('meta_description');
         $table->text('meta_keywords');
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
      Schema::drop('blog_categories');
   }

}
