<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

   /**
    * Bootstrap any application services.
    *
    * @return void
    */
   public function boot() {

      require app_path() . '/Helpers/arrays.php';
      require app_path() . '/Helpers/validators.php';
      require app_path() . '/Helpers/Macros/bootstrap3.php';
      require app_path() . '/Helpers/Macros/general.php';
   }

   /**
    * Register any application services.
    *
    * @return void
    */
   public function register() {
      
   }

}
