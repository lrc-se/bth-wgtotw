<?php

/**
 * Tag routes.
 */

return [
    'routes' => [
        [
            'info' => 'Tag index.',
            'requestMethod' => 'get',
            'path' => '',
            'callable' => ['tagController', 'index']
        ],
        [
            'info' => 'Question index by tag.',
            'requestMethod' => 'get',
            'path' => '{name}',
            'callable' => ['tagController', 'questions']
        ]
    ]
];
