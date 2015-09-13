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


// blogify routes

$use_default_routes = config('blogify.enable_default_routes');

if ($use_default_routes) {
   Route::group(['namespace' => 'App\Http\Controllers'], function() {
      Route::resource('blog', 'BlogController', ['only' => ['index', 'show']]);
      Route::post('blog/{slug}', [
         'as' => 'blog.confirmPass',
         'uses' => 'BlogController@show',
      ]);
      Route::get('blog/archive/{year}/{month}', [
         'as' => 'blog.archive',
         'uses' => 'BlogController@archive'
      ]);
      Route::get('blog/category/{category}', [
         'as' => 'blog.category',
         'uses' => 'BlogController@category',
      ]);
      Route::get('blog/protected/verify/{hash}', [
         'as' => 'blog.askPassword',
         'uses' => 'BlogController@askPassword'
      ]);
      Route::post('comments', [
         'as' => 'comments.store',
         'uses' => 'CommentsController@store'
      ]);
   });
}
///////////////////////////////////////////////////////////////////////////
// Logged in user routes
///////////////////////////////////////////////////////////////////////////

Route::group(['prefix' => 'auth'], function()
{

   Route::group(['middleware' => 'auth'], function()
   {

   });

});


///////////////////////////////////////////////////////////////////////////
// Admin routes
///////////////////////////////////////////////////////////////////////////

$admin = [
   'prefix'    => 'admin',
   'namespace' =>'Controllers\Admin',
];


Route::group($admin, function()
{

   Route::group(['middleware' => 'BlogifyAdminAuthenticate'], function()
   {
      // Dashboard
      Route::get('/', [
         'as'    => 'admin.dashboard',
         'uses'  => 'DashboardController@index'
      ]);

      /**
       *
       * Post routes
       */
      Route::resource('posts', 'PostsController', [
         'except' => 'store', 'update'
      ]);
      Route::post('posts', [
         'as'     => 'admin.posts.store',
         'uses'  => 'PostsController@store'
      ]);
      Route::post('posts/image/upload', [
         'as'    => 'admin.posts.uploadImage',
         'uses'  => 'PostsController@uploadImage',
      ]);
      Route::get('posts/overview/{trashed?}', [
         'as'    => 'admin.posts.overview',
         'uses'  => 'PostsController@index',
      ]);
      Route::get('posts/action/cancel/{hash?}', [
         'as'    => 'admin.posts.cancel',
         'uses'  => 'PostsController@cancel',
      ]);
      Route::get('posts/{hash}/restore', [
         'as' => 'admin.posts.restore',
         'uses' => 'PostsController@restore'
      ]);

      Route::group(['middleware' => 'HasAdminOrAuthorRole'], function() {
         Route::resource('tags', 'TagsController', [
            'except'    => 'store'
         ]);
         Route::post('tags', [
            'as'    => 'admin.tags.store',
            'uses'  => 'TagsController@storeOrUpdate'
         ]);
         Route::get('tags/overview/{trashed?}', [
            'as'    => 'admin.tags.overview',
            'uses'  => 'TagsController@index',
         ]);
         Route::get('tags/{hash}/restore', [
            'as' => 'admin.tags.restore',
            'uses' => 'TagsController@restore'
         ]);

         Route::get('comments/{revised?}', [
            'as'    => 'admin.comments.index',
            'uses'  => 'CommentsController@index'
         ]);
         Route::get('comments/changestatus/{hash}/{revised}', [
            'as'    => 'admin.comments.changeStatus',
            'uses'  => 'CommentsController@changeStatus'
         ]);
      });

      Route::resource('profile', 'ProfileController');

      ///////////////////////////////////////////////////////////////////////////
      // API routes
      ///////////////////////////////////////////////////////////////////////////

      $api = [
         'prefix' => 'api',
      ];

      Route::group($api, function()
      {
         Route::get('sort/{table}/{column}/{order}/{trashed?}', [
            'as'    => 'admin.api.sort',
            'uses'  => 'ApiController@sort'
         ]);

         Route::get('slug/checkIfSlugIsUnique/{slug}', [
            'as'    => 'admin.api.slug.checkIfUnique',
            'uses'  => 'ApiController@checkIfSlugIsUnique',
         ]);

         Route::post('autosave', [
            'as'    => 'admin.api.autosave',
            'uses'  => 'ApiController@autoSave',
         ]);

         Route::get('tags/{hash}', [
            'as' => 'admin.api.tags',
            'uses' => 'ApiController@getTag'
         ]);
      });

   });

});
