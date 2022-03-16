<?php



return [
    'encoding' => env('STYLEABLE_ENCODING', 'utf-8'),
    /**
     * Pass true to use Styleable as global. No need to use HasStyle trait
     */
    'is_global' => true,
    /**
     * Define your custom modules. Module files extension should be ended with .module.scss
     */
    'modules_path' => resource_path('sass/modules')
];
