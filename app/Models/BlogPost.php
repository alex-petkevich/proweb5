<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel {

   use SoftDeletes;

   protected $guarded = array();
   protected $table = 'blog_posts';
   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:blog_posts,name',
      'title' => 'required'
   );

   public function categories() {
      return $this->belongsToMany('BlogCategory', null, 'blog_post_id', 'blog_category_id');
   }

   public function comments() {
      return $this->hasMany('BlogComment');
   }

   public static function getSortOptions() {
      $sort = array(
         '' => '-',
         'title' => trans('blog_posts.title'),
         'created_at' => trans('users.created')
      );
      return $sort;
   }

   /*  public function getTreeArray($parent_id = 0) {
     $pagesArr = $this->get()->toArray();
     return buildTree($pagesArr);
     } */
}
