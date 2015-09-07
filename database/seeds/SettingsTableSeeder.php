<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $settings = array(
         array(
            'name' => 'TABLE_ELEMENTS',
            'description' => 'Постраничное разбиение элементов, количество на странице',
            'value' => '20',
            'title' => 'Количество элементов в таблице'
         ),
         array(
            'name' => 'FEEDBACK_EMAIL',
            'description' => 'email адрес для системных сообщений',
            'value' => 'alex@mrdoggy.info',
            'title' => 'Email администратора'
         )
      );

      DB::table('settings')->insert($settings);
   }
}
