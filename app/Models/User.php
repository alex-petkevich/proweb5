<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

   use Authenticatable, CanResetPassword, SoftDeletes;

   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'users';

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = array('password', 'remember_token');


   public static $rules = array(
      'email' => 'required|email|unique:users,email',
      'password' => 'required|alpha_num|between:4,50',
      'username' => 'required|alpha_num|between:2,20|unique:users,username'
   );

   /**
    * Get the unique identifier for the user.
    *
    * @return mixed
    */
   public function getAuthIdentifier()
   {
      return $this->getKey();
   }

   /**
    * Get the password for the user.
    *
    * @return string
    */
   public function getAuthPassword()
   {
      return $this->password;
   }

   /**
    * Get the e-mail address where password reminders are sent.
    *
    * @return string
    */
   public function getReminderEmail()
   {
      return $this->email;
   }

   public function roles()
   {
      return $this->belongsToMany('Role');
   }

   public function isAdmin()
   {
      $admin_role = Role::whereRole('admin')->first();
      return $admin_role != null && $this->roles->contains($admin_role->id);
   }

   public function isRegular()
   {
      $roles = array_filter($this->roles->toArray());
      return empty($roles);
   }

   /**
    * Get the token value for the "remember me" session.
    *
    * @return string
    */
   public function getRememberToken()
   {
      return $this->remember_token;
   }

   /**
    * Set the token value for the "remember me" session.
    *
    * @param  string $value
    * @return void
    */
   public function setRememberToken($value)
   {
      $this->remember_token = $value;
   }

   /**
    * Get the column name for the "remember me" token.
    *
    * @return string
    */
   public function getRememberTokenName()
   {
      return 'remember_token';
   }

   public static function getSortOptions()
   {
      $sort = array(
         '' => '-',
         'username' => trans('users.username_'),
         'email' => trans('users.email_'),
         'created_at' => trans('users.created')
      );
      return $sort;
   }

   /**
    * Get the e-mail address where password reset links are sent.
    *
    * @return string
    */
   public function getEmailForPasswordReset()
   {
      return $this->email;
   }
}
