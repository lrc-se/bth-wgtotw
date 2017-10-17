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
        ],
        
        // comments
        [
            'info' => 'Write question comment page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/comment',
            'callable' => ['commentController', 'create']
        ],
        [
            'info' => 'Write answer comment page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer/{answerId:digit}/comment',
            'callable' => ['commentController', 'create']
        ],
        [
            'info' => 'Edit comment page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/comment/{commentId:digit}',
            'callable' => ['commentController', 'update']
        ],
        [
            'info' => 'Edit answer comment page/handler.',
            'requestMethod' => 'get|post',
            'path' => '{questionId:digit}/answer/{answerId:digit}/comment/{commentId:digit}',
            'callable' => function ($questionId, $answerId, $commentId) {
                $this->di->commentController->update($questionId, $commentId, $answerId);
            }
        ],
        
        // votes
        [
            'info' => 'Register down vote.',
            'requestMethod' => 'get',
            'path' => '{questionId:digit}/vote/{$postId}/down',
            'callable' => ['voteController', 'voteDown']
        ],
        [
            'info' => 'Register up vote.',
            'requestMethod' => 'get',
            'path' => '{questionId:digit}/vote/{$postId}/up',
            'callable' => ['voteController', 'voteUp']
        ],
        [
            'info' => 'Cancel vote.',
            'requestMethod' => 'get',
            'path' => '{questionId:digit}/vote/{$postId}/cancel',
            'callable' => ['voteController', 'cancelVote']
        ]
    ]
];
