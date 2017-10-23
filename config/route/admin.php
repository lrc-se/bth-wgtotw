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
            'callable' => ['adminUserController', 'users']
        ],
        [
            'info' => 'Admin user create page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/create',
            'callable' => ['adminUserController', 'createUser']
        ],
        [
            'info' => 'Admin user edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/edit/{id:digit}',
            'callable' => ['adminUserController', 'updateUser']
        ],
        [
            'info' => 'Admin user delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'user/delete/{id:digit}',
            'callable' => ['adminUserController', 'deleteUser']
        ],
        [
            'info' => 'Admin user restore handler.',
            'requestMethod' => 'post',
            'path' => 'user/restore/{id:digit}',
            'callable' => ['adminUserController', 'restoreUser']
        ],
        
        // tags
        [
            'info' => 'Admin tag list.',
            'requestMethod' => 'get',
            'path' => 'tag',
            'callable' => ['adminTagController', 'tags']
        ],
        [
            'info' => 'Admin tag create page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/create',
            'callable' => ['adminTagController', 'createTag']
        ],
        [
            'info' => 'Admin tag edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/edit/{id:digit}',
            'callable' => ['adminTagController', 'updateTag']
        ],
        [
            'info' => 'Admin tag delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'tag/delete/{id:digit}',
            'callable' => ['adminTagController', 'deleteTag']
        ],
        
        // questions
        [
            'info' => 'Admin question list.',
            'requestMethod' => 'get',
            'path' => 'question',
            'callable' => ['adminPostController', 'questions']
        ],
        [
            'info' => 'Admin question view.',
            'requestMethod' => 'get',
            'path' => 'question/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->viewPost('question', $id);
            }
        ],
        [
            'info' => 'Admin question edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'question/edit/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->updatePost('question', $id);
            }
        ],
        [
            'info' => 'Admin question delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'question/delete/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->deletePost('question', $id);
            }
        ],
        [
            'info' => 'Admin question restore handler.',
            'requestMethod' => 'post',
            'path' => 'question/restore/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->restorePost('question', $id);
            }
        ],
        
        // answers
        [
            'info' => 'Admin answer list.',
            'requestMethod' => 'get',
            'path' => 'question/{questionId:digit}/answer',
            'callable' => ['adminPostController', 'answers']
        ],
        [
            'info' => 'Admin answer view.',
            'requestMethod' => 'get',
            'path' => 'answer/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->viewPost('answer', $id);
            }
        ],
        [
            'info' => 'Admin answer edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'answer/edit/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->updatePost('answer', $id);
            }
        ],
        [
            'info' => 'Admin answer delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'answer/delete/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->deletePost('answer', $id);
            }
        ],
        [
            'info' => 'Admin answer restore handler.',
            'requestMethod' => 'post',
            'path' => 'answer/restore/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->restorePost('answer', $id);
            }
        ],
        
        // comments
        [
            'info' => 'Admin question comment list.',
            'requestMethod' => 'get',
            'path' => 'question/{parentId:digit}/comment',
            'callable' => ['adminPostController', 'comments']
        ],
        [
            'info' => 'Admin answer comment list.',
            'requestMethod' => 'get',
            'path' => 'answer/{parentId:digit}/comment',
            'callable' => ['adminPostController', 'comments']
        ],
        [
            'info' => 'Admin comment view.',
            'requestMethod' => 'get',
            'path' => 'comment/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->viewPost('comment', $id);
            }
        ],
        [
            'info' => 'Admin comment edit page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'comment/edit/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->updatePost('comment', $id);
            }
        ],
        [
            'info' => 'Admin comment delete page/handler.',
            'requestMethod' => 'get|post',
            'path' => 'comment/delete/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->deletePost('comment', $id);
            }
        ],
        [
            'info' => 'Admin comment restore handler.',
            'requestMethod' => 'post',
            'path' => 'comment/restore/{id:digit}',
            'callable' => function ($id) {
                return $this->di->adminPostController->restorePost('comment', $id);
            }
        ]
    ]
];
