<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/25/14
 * Time: 5:13 PM
 */

Form::macro('textField', function ($name, $label = null, $value = null, $attributes = array()) {
   $element = Form::text($name, $value, fieldAttributes($name, $attributes));

   return fieldWrapper($name, $label, $element);
});

Form::macro('passwordField', function ($name, $label = null, $attributes = array()) {
   $element = Form::password($name, fieldAttributes($name, $attributes));

   return fieldWrapper($name, $label, $element);
});

Form::macro('textareaField', function ($name, $label = null, $value = null, $attributes = array()) {
   $element = Form::textarea($name, $value, fieldAttributes($name, $attributes));

   return fieldWrapper($name, $label, $element);
});

Form::macro('selectField', function ($name, $label = null, $options, $value = null, $attributes = array()) {
   $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

   return fieldWrapper($name, $label, $element);
});

Form::macro('selectMultipleField', function ($name, $label = null, $options, $value = null, $attributes = array()) {
   $attributes = array_merge($attributes, ['multiple' => true]);
   $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

   return fieldWrapper($name, $label, $element);
});

Form::macro('checkboxField', function ($name, $label = null, $value = 1, $checked = null, $attributes = array()) {
   $attributes = array_merge(['id' => 'id-field-' . $name], $attributes);

   $out = '<div class="checkbox';
   $out .= fieldError($name) . '">';
   $out .= '<label>';
   $out .= Form::checkbox($name, $value, $checked, $attributes) . ' ' . $label;
   $out .= '</div>';

   return $out;
});

function fieldWrapper($name, $label, $element)
{
   $out = '<div class="form-group';
   $out .= fieldError($name) . '">';
   $out .= fieldLabel($name, $label);
   $out .= $element;
   $out .= '</div>';

   return $out;
}

function fieldError($field)
{
   $error = '';

   if ($errors = Session::get('errors')) {
      $error = $errors->first($field) ? ' has-error' : '';
   }

   return $error;
}

function fieldLabel($name, $label)
{
   if (is_null($label)) return '';

   $name = str_replace('[]', '', $name);

   $out = '<label for="id-field-' . $name . '" class="control-label">';
   $out .= $label . '</label>';

   return $out;
}

function fieldAttributes($name, $attributes = array())
{
   $name = str_replace('[]', '', $name);

   return array_merge(['class' => 'form-control', 'id' => 'id-field-' . $name], $attributes);
}


Html::macro('table', function ($fields = array(), $data = array(), $resource, $showEdit = true, $showDelete = true, $showView = true) {
   $table = '<table class="table table-bordered">';
   $table .= '<tr>';
   if ($showEdit || $showDelete || $showView)
      $table .= '<th></th>';

   foreach ($fields as $field) {
      $table .= '<th>' . Str::title($field) . '</th>';
   }
   $table .= '</tr>';
   foreach ($data as $d) {
      $table .= '<tr>';

      if ($showEdit || $showDelete || $showView) {
         $table .= '<td>';
         if ($showEdit)
            $table .= '<a href="' . $resource . '/' . $d->id . '/edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
         if ($showView)
            $table .= '<a href="' . $resource . '/' . $d->id . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View</a> ';
         if ($showDelete)
            $table .= '<a href="' . $resource . '/' . $d->id . '/delete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a> ';
         $table .= '</td>';
      }
      foreach ($fields as $key) {
         $table .= '<td>' . $d->$key . '</td>';
      }
      $table .= '</tr>';
   }
   $table .= '</table>';
   return $table;
});

