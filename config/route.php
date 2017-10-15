<?php

/**
 * Route config.
 */

return [
    'routeFiles' => [
        [
            'mount' => null,
            'file' => __DIR__ . '/route/internal.php'
        ],
        [
            'mount' => null,
            'file' => __DIR__ . '/route/flat-file-content.php'
        ],
        [
            'mount' => 'user',
            'file' => __DIR__ . '/route/user.php'
        ],
        [
            'mount' => 'question',
            'file' => __DIR__ . '/route/question.php'
        ],
        [
            'mount' => null,
            'file' => __DIR__ . '/route/404.php',
            'sort' => 1000
        ]
    ]
];
