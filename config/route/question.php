<?php

/**
 * Question routes.
 */

return [
    'routes' => [
        // questions
        [
            'info' => 'Question index page.',
            'requestMethod' => 'get',
            'path' => '',
            'callable' => ['questionController', 'index']
        ],
        [
            'info' => 'View question page.',
            'requestMethod' => 'get',
            'path' => '{id:digit}',
            'callable' => ['questionController', 'view']
        ],
        [
            'info' => 'Write question page.',
            'requestMethod' => 'get',
            'path' => 'create',
            'callable' => ['questionController', 'create']
        ],
        [
            'info' => 'Write question handler.',
            'requestMethod' => 'post',
            'path' => 'create',
            'callable' => ['questionController', 'handleCreate']
        ],
        [
            'info' => 'Edit question page.',
            'requestMethod' => 'get',
            'path' => 'edit/{id:digit}',
            'callable' => ['questionController', 'update']
        ],
        [
            'info' => 'Edit question handler.',
            'requestMethod' => 'post',
            'path' => 'edit/{id:digit}',
            'callable' => ['questionController', 'handleUpdate']
        ],
        
        // answers
        [
            'info' => 'Write answer page.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer',
            'callable' => ['answerController', 'create']
        ],
        [
            'info' => 'Edit answer page.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer/{answerId:digit}',
            'callable' => ['answerController', 'update']
        ]
    ]
];
