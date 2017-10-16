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
            'info' => 'Write question page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'create',
            'callable' => ['questionController', 'create']
        ],
        [
            'info' => 'Edit question page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'edit/{id:digit}',
            'callable' => ['questionController', 'update']
        ],
        
        // answers
        [
            'info' => 'Write answer page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer',
            'callable' => ['answerController', 'create']
        ],
        [
            'info' => 'Edit answer page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer/{answerId:digit}',
            'callable' => ['answerController', 'update']
        ]
    ]
];
