<?php

return [

    /**
     * Array with all available character sets
     *
     */
    'char_sets' => [
        'hash'      => 'ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvw0123456789',
        'password'  => 'ABCDEFGHIJKLMNOPQRSTUVWabcdefghijklmnopqrstuvw0123456789@$?!',
    ],

    /**
     * Defines how many items per
     * page you want to show
     *
     */
    'items_per_page' => 20,

    /**
     * Paths where uploaded images
     * wil be placed
     *
     */
    'upload_paths'  => [
        'posts' => [
            'images'    => 'uploads/posts/',
        ],
        'profiles' => [
            'profilepictures' => 'uploads/profilepictures/',
        ],
    ],

    /**
     * The size where an uploaded
     * image will be resized to
     *
     */
    'image_sizes'   => [
        'posts' => [500, null],
        'profilepictures' => [100, 100],
    ],

    /**
     * Define if new comments
     * first needs approval
     *
     */
    'approve_comments_first' => false,

    /**
     * Set this to true when you have ran the
     * blogify:generate command to enable the
     * routes of the public part
     *
     */
    'enable_default_routes' => true,
];