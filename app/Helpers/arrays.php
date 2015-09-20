<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 20.09.15
 * Time: 23:40
 */


function alignTreeArray(&$array, $fill = '-')
{

   foreach ($array as &$element) {

      if (!empty($element['children'])) {
         $element['children'] = alignTreeArray($element['children'], $fill);
      }
      $element['title'] = str_repeat($fill, $element['shift']) . $element['title'];
   }

   return $array;
}

function flattenTreeArray(array &$input)
{
   $return = array();

   foreach ($input as $array) {
      $return[] = $array;
      if (!empty($array['children'])) {
         $return = array_merge($return, flattenTreeArray($array['children']));
      }
   }

   return $return;
}

function buildTree(array &$elements, $parentId = 0, $shift = 0)
{

   $branch = array();

   foreach ($elements as &$element) {

      if ($element['parent_id'] == $parentId) {
         $children = buildTree($elements, $element['id'], $shift + 3);
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
