<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends BaseModel
{

   use SoftDeletes;

   protected $guarded = array();
   protected $table = 'proposals';
   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:proposals,name',
      'title' => 'required'
   );

   public function user()
   {
      return $this->belongsTo('\User');
   }

   public static function getSortOptions()
   {
      $sort = array(
         '' => '-',
         'title' => trans('proposals.title'),
         'publishied_at' => trans('proposals.published')
      );
      return $sort;
   }
}
