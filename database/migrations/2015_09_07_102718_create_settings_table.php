<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up() {
      Schema::create('settings', function(Blueprint $table) {
         $table->increments('id');
         $table->string('name', 100)->unique();
         $table->string('value', 255);
         $table->string('title', 255);
         $table->string('description', 255);
         $table->string('group', 100)->nullable();
         $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down() {
      Schema::drop('settings');
   }

}
