<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostCategoriesTable extends Migration
{

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('blog_posts_categories', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('blog_post_id')->unsigned()->index();
         $table->integer('blog_category_id')->unsigned()->index();
         $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
         $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::drop('blog_posts_categories');
   }

}
