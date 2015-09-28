<?php

/**
 * Key value pair of presets with the name and dimensions to be used
 *
 * 'PRESET_NAME' => array(
 *   'width'  => INT, // in pixels
 *   'height' => INT, // in pixels
 *   'method' => STRING, // 'crop' or 'resize'
 *   'background_color' => '#000000', //  (optional) Used with resize
 * )
 *
 * eg   'presets' => array(
 *        '800x600' => array(
 *          'width' => 800,
 *          'height' => 600,
 *          'method' => 'resize',
 *          'background_color' => '#000000',
 *        )
 *      ),
 *
 */
return array(
   '100x100' => array(
      'width' => 100,
      'height' => 100,
      'method' => 'resize',
   ),
   '150x150' => array(
      'width' => 150,
      'height' => 150,
      'method' => 'crop',
   ),
   '150x150resize' => array(
      'width' => 150,
      'height' => 150,
      'method' => 'resize',
   ),
);
