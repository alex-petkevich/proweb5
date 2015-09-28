<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentToBlogCategories extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('blog_categories', function (Blueprint $table) {
         $table->integer("parent_id")->default(0);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('blog_categories', function (Blueprint $table) {
         $table->dropColumn("parent_id");
      });
   }
}
