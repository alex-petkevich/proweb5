<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPasswordFieldToPostsTable extends Migration {

    public function up()
    {
        Schema::table('posts', function(Blueprint $table) {
            $table->string('password')->after('being_edited_by')->nullable();
        });
    }

    public function down()
    {
        Schema::table('posts', function(Blueprint $table)
        {
            $table->dropColumn('password');
        });
    }
}