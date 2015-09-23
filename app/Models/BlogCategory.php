<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends BaseModel
{
   use SoftDeletes;

   protected $table = 'blog_categories';

   public static $rules = array(
      'name' => 'required|alpha_dash|min:1|max:200|unique:blog_categories,name'
   );
}
