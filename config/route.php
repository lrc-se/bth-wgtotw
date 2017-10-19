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
            'file' => __DIR__ . '/route/default.php'
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
            'mount' => 'tag',
            'file' => __DIR__ . '/route/tag.php'
        ],
        [
            'mount' => 'admin',
            'file' => __DIR__ . '/route/admin.php'
        ],
        [
            'mount' => null,
            'file' => __DIR__ . '/route/404.php',
            'sort' => 1000
        ]
    ]
];
