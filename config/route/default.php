<?php

/**
 * Default routes.
 */

return [
    'routes' => [
        [
            'info' => 'Start page.',
            'requestMethod' => 'get',
            'path' => '',
            'callable' => ['defaultController', 'index']
        ],
        [
            'info' => 'About page.',
            'requestMethod' => 'get',
            'path' => 'about',
            'callable' => ['defaultController', 'about']
        ]
    ]
];
