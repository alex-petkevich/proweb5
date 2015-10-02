<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel {

   use SoftDeletes;

   protected $guarded = array();
   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:pages,name',
      'title' => 'required'
   );

   public function getTreeArray($parent_id = 0, $active = 0)
   {
      $pagesArr = ($active ? $this->where('active', 1)->get() : $this->get());
      $pages = $pagesArr->toArray();
      return buildTree($pages);
   }

}
