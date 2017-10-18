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
        ]
    ]
];
