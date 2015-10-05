<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/25/14
 * Time: 2:54 PM
 */

Validator::extend('alpha_spaces', function ($attribute, $value) {
   return preg_match('/^[\pL\s]+$/u', $value);
});