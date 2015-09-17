<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
   use SoftDeletes;

   protected $guarded = array();

   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:pages,name',
      'title' => 'required'
   );
}