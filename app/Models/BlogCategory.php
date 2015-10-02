<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends BaseModel
{
   use SoftDeletes;

   protected $table = 'blog_categories';

   public static $rules = array(
      'name' => 'required|alpha_dash|min:1|max:200|unique:blog_categories,name'
   );
   protected $fillable = ['parent_id'];

   public function getTreeArray($parent_id = 0, $active = 0)
   {
      $pagesArr = ($active ? $this->where('active', 1)->get() : $this->get());
      $pages = $pagesArr->toArray();
      return buildTree($pages);
   }
}
