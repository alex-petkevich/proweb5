<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel {

   use SoftDeletes;

   protected $guarded = array();
   public static $rules = array(
      'name' => 'required|alpha_dash|min:2|max:200|unique:pages,name',
      'title' => 'required'
   );

   public function getTreeArray($parent_id = 0) {
      $pagesArr = $this->get()->toArray();
      return $this->buildTree($pagesArr);
   }

   private function buildTree(array &$elements, $parentId = 0, $shift = 0) {

      $branch = array();

      foreach ($elements as &$element) {

         if ($element['parent_id'] == $parentId) {
            $children = $this->buildTree($elements, $element['id'], $shift + 3);
            if ($children) {
               $element['children'] = $children;
            }
            $element['shift'] = $shift;
            $branch[$element['id']] = $element;
            unset($element);
         }
      }
      return $branch;
   }

}
