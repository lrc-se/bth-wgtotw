<?php

/**
 * Admin routes.
 */

return [
    'routes' => [
        // start
        [
            'info' => 'Admin page.',
            'requestMethod' => 'get',
            'path' => '',
            'callable' => ['adminController', 'index']
        ],
        
        // users
        [
            'info' => 'Admin user list.',
            'requestMethod' => 'get',
            'path' => 'user',
            'callable' => ['adminController', 'users']
        ],
        [
            'info' => 'Admin user create page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/create',
            'callable' => ['adminController', 'createUser']
        ],
        [
            'info' => 'Admin user edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/edit/{id:digit}',
            'callable' => ['adminController', 'updateUser']
        ],
        [
            'info' => 'Admin user delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/delete/{id:digit}',
            'callable' => ['adminController', 'deleteUser']
        ],
        [
            'info' => 'Admin user restore handler.',
            'requestMethod' => 'post',
            'path' => 'user/restore/{id:digit}',
            'callable' => ['adminController', 'restoreUser']
        ],
        
        // tags
        [
            'info' => 'Admin tag list.',
            'requestMethod' => 'get',
            'path' => 'tag',
            'callable' => ['adminController', 'tags']
        ],
        [
            'info' => 'Admin tag create page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/create',
            'callable' => ['adminController', 'createTag']
        ],
        [
            'info' => 'Admin tag edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/edit/{id:digit}',
            'callable' => ['adminController', 'updateTag']
        ],
        [
            'info' => 'Admin tag delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/delete/{id:digit}',
            'callable' => ['adminController', 'deleteTag']
        ],
        
        // questions
        [
            'info' => 'Admin question list.',
            'requestMethod' => 'get',
            'path' => 'question',
            'callable' => ['adminController', 'questions']
        ],
        [
            'info' => 'Admin question edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'question/edit/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminController->updatePost('question', $id);
            }
        ],
        [
            'info' => 'Admin question delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'question/delete/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminController->deletePost('question', $id);
            }
        ],
        [
            'info' => 'Admin question restore handler.',
            'requestMethod' => 'post',
            'path' => 'question/restore/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminController->restorePost('question', $id);
            }
        ]
    ]
];
