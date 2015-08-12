<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtendedToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->string("avatar",255)->nullable();
            $table->date("birthdate")->nullable();
            $table->boolean("active")->nullable();
            $table->string("fullname",255)->nullable();
            $table->text("description")->nullable();
            $table->boolean("notifications")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->dropColumn("avatar");
            $table->dropColumn("birthdate");
            $table->dropColumn("active");
            $table->dropColumn("fullname");
            $table->dropColumn("description");
            $table->dropColumn("notifications");
		});
	}

}
