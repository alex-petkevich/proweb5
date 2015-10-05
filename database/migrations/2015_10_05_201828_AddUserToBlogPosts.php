<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToBlogPosts extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('blog_posts', function (Blueprint $table) {
         $table->integer("user_id")->default(0);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('blog_posts', function (Blueprint $table) {
         $table->dropColumn("user_id");
      });
   }
}
