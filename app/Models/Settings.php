<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends BaseModel
{
   use SoftDeletes;

   protected $guarded = array();

   public $timestamps = false;

   const TTL_CACHE = 10;

   public static $rules = array(
      'name' => 'required|min:1|max:200'
   );

   public static function getValue($key)
   {
      if (Cache::has($key)) {
         return Cache::get($key);
      }

      $val = Settings::where('name', '=', $key)->first();
      
      if ($val === null)
         return null;

      Cache::put($key, $val->value, self::TTL_CACHE);

      return $val->value;
   }

   public static function clearCache()
   {
      Cache::flush();
   }
}
