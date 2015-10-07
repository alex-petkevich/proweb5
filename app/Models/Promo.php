<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends BaseModel {

   use SoftDeletes;

   protected $guarded = array();
   protected $table = 'promos';
   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:promos,name',
      'img' => 'required'
   );

   public function category() {
      return $this->belongsTo('PromoCategory');
   }

   public static function getSortOptions() {
      $sort = array(
         '' => '-',
         'name' => trans('promos.name'),
         'shows' => trans('promos.shows'),
         'clicks' => trans('promos.clicks')
      );
      return $sort;
   }

}
