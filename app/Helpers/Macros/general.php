<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/25/14
 * Time: 2:59 PM
 */

Form::macro("check", function($name, $value = 1, $checked = null, $options = array()){
   return Form::hidden($name, 0).Form::checkbox($name, $value, $checked, $options);
});

Form::macro('errors', function($errors, $field = false)
{
   if ($errors->any())
   {
      if ($field && !$errors->has($field))
      {
         return null;
      }
      return View::make('partials.errors_form', [
         'errors' => $errors,
         'field' => $field

      ]);
   }

   return null;
});

HTML::macro('gravatar', function($email, $size = 32, $default = 'mm')
{
   return '<img src="http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=' . $size . '&d=' . $default . '" alt="Avatar">';
});
