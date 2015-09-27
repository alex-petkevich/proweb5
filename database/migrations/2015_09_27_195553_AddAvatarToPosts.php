<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToPosts extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('blog_posts', function (Blueprint $table) {
         $table->string("avatar", 255)->nullable();
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
         $table->dropColumn("avatar");
      });
   }
}
