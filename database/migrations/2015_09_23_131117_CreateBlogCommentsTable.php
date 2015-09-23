<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentsTable extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up() {
      Schema::create('blog_comments', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('user_id');
         $table->integer('blog_post_id');
         $table->string('title');
         $table->text('comment');
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
   public function down() {
      Schema::drop('blog_posts');
   }

}
