<?php

return array(
   /**
    * The location of the public folder for your laravel installation
    */
   'public_path' => '',
   /**
    * The location of the directory where you keep your uploaded images on the
    * site relative to the public_path option
    */
   'files_directory' => public_path(),
   /**
    * The location of the directory where you would like to store
    * the rendered Imagecache files relative to the public_path option
    */
   'imagecache_directory' => 'storage/imagecache/',
   /**
    * The name of the field to check for a filename if passing an array
    * or an object instead of a string to the get() method
    */
   'filename_field' => 'filename',
   /**
    * The quality of the generated image. Possbile values are
    * 0 (worst) - 100 (best). Only applies for JPEG images.
    */
   'quality' => 90,
);
