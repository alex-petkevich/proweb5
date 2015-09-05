<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends BaseModel
{
   use SoftDeletes;

   protected $guarded = array();

   public static $rules = array(
      'name' => 'required|alpha|min:1|max:200|unique:settings,name'
   );
}
