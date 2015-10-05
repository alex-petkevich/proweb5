<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

   public function run()
   {
      $roles = array(
         array(
            'role' => 'admin',
            'description' => 'Administrative privileges',
            'updated_at' => DB::raw('NOW()'),
            'created_at' => DB::raw('NOW()')
         ),
         array(
            'role' => 'member',
            'description' => 'Registered members',
            'updated_at' => DB::raw('NOW()'),
            'created_at' => DB::raw('NOW()')
         ),
      );

      DB::table('roles')->insert($roles);
   }

}