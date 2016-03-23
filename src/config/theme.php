<?php

return [
    'basePath'    => base_path('resources/themes'),
    'themes'      => [
        'admin'    => ['bootstrap', 'jquerymobile'],
        'frontend' => ['bootstrap', 'flat', 'foundation'],
    ],
    'current_theme' => [
        'admin'    => 'bootstrap',
        'frontend' => 'foundation',
    ],
    'current_group' => 'admin',
];
