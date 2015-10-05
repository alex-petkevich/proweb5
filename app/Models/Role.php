<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
   use SoftDeletes;

   protected $guarded = array();

   public static $rules = array(
      'role' => 'required|alpha|min:2|max:200|unique:roles,role'
   );
}
