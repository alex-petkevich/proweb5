<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

   public function run()
   {
       $roles = array(
         array(
            'role' => 'Admin',
            'description' => 'Administrative privileges',
            'updated_at' => DB::raw('NOW()'),
            'created_at' => DB::raw('NOW()')
         ),
         array(
            'role' => 'Member',
            'description' => 'Registered members',
            'updated_at' => DB::raw('NOW()'),
            'created_at' => DB::raw('NOW()')
         ),
          array(
             'role' => 'Reviewer',
             'description' => 'Articles reviewer',
             'updated_at' => DB::raw('NOW()'),
             'created_at' => DB::raw('NOW()')
          ),
          array(
             'role' => 'Author',
             'description' => 'Authors',
             'updated_at' => DB::raw('NOW()'),
             'created_at' => DB::raw('NOW()')
          )
      );

      DB::table('roles')->insert($roles);
   }

}