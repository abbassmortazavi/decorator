<?php

return [
    'commands' => env('REGISTER_COMMANDS', true),
    'migrations' => env('REGISTER_MIGRATIONS', true),
    'translations' => env('REGISTER_TRANSLATIONS', true),
    'views' => env('REGISTER_VIEWS', true),
    'config' => env('REGISTER_CONFIG', true),
    'helper' => env('REGISTER_HELPER', true),
    'policies' => env('REGISTER_POLICIES', true),
    'facades' => env('REGISTER_FACADES', true),
    'bladeExtensions' => env('REGISTER_BLADE_EXTENSIONS', true),
    'api_routes' => env('REGISTER_API_ROUTES', true),
];
