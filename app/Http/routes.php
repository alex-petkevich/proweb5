<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */


Route::middleware('admin_role_only', function () {
   if (!Auth::user()->isAdmin()) {
      return Redirect::intended('/')->withMessage(trans('login.not_enough_permissions'));
   }
});

Route::middleware('not_guest', function () {
   if (Auth::guest()) {
      return Redirect::intended('/')->withInput()->with('message', trans('users.must_be_logged'));
   }
});

Route::middleware('regular_user', function () {
   if (!Auth::guest()) {
      if (!Auth::user()->isRegular()) {
         return Redirect::back()->with('message', trans('login.not_authenticated'));
      }
   }
});

Route::middleware('admin.auth', function () {
   if (Auth::guest()) {
      return Redirect::to('login');
   }
});

Route::middleware('un_auth', function () {
   if (!Auth::guest()) {
      Auth::logout();
   }
});


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('logout', array('as' => 'login.logout', 'uses' => 'LoginController@logout'));
Route::get('profile', array('as' => 'user.profile', 'uses' => 'UsersController@editProfile'));


Route::group(array('before' => 'un_auth'), function() {
   Route::get('login', array('as' => 'login.index', 'uses' => 'LoginController@index'));
   Route::post('login', array('uses' => 'LoginController@login'));

   Route::get('register', array('as' => 'login.register', 'uses' => 'LoginController@register'));
   Route::post('register', array('uses' => 'LoginController@store'));

   Route::get('password/remind', array('as' => 'password.remind', 'uses' => 'LoginController@showReminderForm'));
   Route::post('password/remind', array('uses' => 'LoginController@sendReminder'));

   Route::get('password/reset/{token}', array('as' => 'password.reset', 'uses' => 'LoginController@showResetForm'));
   Route::post('password/reset/{token}', array('uses' => 'LoginController@resetPassword'));
});

Route::resource('blog', 'BlogController');
Route::resource('pages', 'PagesController');
Route::resource('posts', 'PostsController');

Route::group(array('after' => 'admin.auth'), function() {
   Route::get('dashboard', array('as' => 'login.dashboard', 'uses' => 'LoginController@dashboard'));

   Route::group(array('before' => 'admin_role_only'), function() {
      // admin routes
      Route::resource('roles', 'RolesController');
      Route::resource('users', 'UsersController');
      Route::resource('settings', 'SettingsController', ['except' => ['show']]);

      Route::get('users/{users}/edit_profile', array('as' => 'users.edit_profile', 'uses' => 'UsersController@edit_profile'));
      Route::get('users/{users}/edit_notes', array('as' => 'users.edit_notes', 'uses' => 'UsersController@edit_notes'));
      Route::patch('users/{users}/edit_profile', array('as' => 'users.edit_profile', 'uses' => 'UsersController@update_profile'));
      Route::patch('users/{users}/edit_notes', array('as' => 'users.edit_notes', 'uses' => 'UsersController@update_notes'));
      Route::patch('users/{users}/edit', array('as' => 'users.edit', 'uses' => 'UsersController@update'));
      Route::post('upload', array('uses' => 'UsersController@uploadAvatarImage'));
      Route::post('users/update_state', array('uses' => 'UsersController@updateState'));

      Route::get('settings/index_payment', array('as' => 'settings.index_payment', 'uses' => 'SettingsController@index_payment'));
      Route::patch('settings', array('as' => 'settings', 'uses' => 'SettingsController@update'));
   });

   // Routes only for registered users
});
