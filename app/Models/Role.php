<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel {
   use SoftDeletes;
   
   protected $guarded = array();

   public static $rules = array(
      'role' => 'required|alpha|min:2|max:200|unique:roles,role'
   );

   /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    | For more information pleas check out the official Laravel docs at
    | http://laravel.com/docs/5.0/eloquent#relationships
    |
    */

   public function user()
   {
      return $this->hasMany('App\user');
   }

   /*
   |--------------------------------------------------------------------------
   | Scopes
   |--------------------------------------------------------------------------
   |
   | For more information pleas check out the official Laravel docs at
   | http://laravel.com/docs/5.0/eloquent#queryscopes
   |
   */

   public function scopeByAdminRoles($query)
   {
      $query->whereName('admin')
         ->orWhere('name', '=', 'Author')
         ->orWhere('name', '=', 'reviewer');
   }
}
