<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up() {
      Schema::create('blog_posts', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name')->unique();
         $table->string('title');
         $table->text('description');
         $table->string('meta_title');
         $table->text('meta_description');
         $table->text('meta_keywords');
         $table->text('only_for_roles');
         $table->boolean('active')->default(true);
         $table->boolean('is_comments')->default(true);
         $table->timestamps();
         $table->timestamp('publishied_at');
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
