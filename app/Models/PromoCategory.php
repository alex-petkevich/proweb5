<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCategory extends BaseModel
{
   use SoftDeletes;

   protected $table = 'promos_categories';

   public static $rules = array(
      'name' => 'required|alpha_dash|min:1|max:200|unique:promos_categories,name'
   );
   protected $guarded = [];
}
