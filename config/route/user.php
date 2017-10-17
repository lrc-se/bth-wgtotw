<?php

/**
 * User account routes.
 */

return [
    'routes' => [
        [
            'info' => 'User index.',
            'requestMethod' => 'get',
            'path' => 'all',
            'callable' => ['userController', 'index']
        ],
        [
            'info' => 'Profile page.',
            'requestMethod' => 'get',
            'path' => '{id:digit}',
            'callable' => ['userController', 'profile']
        ],
        [
            'info' => 'Registration page.',
            'requestMethod' => 'get',
            'path' => 'create',
            'callable' => ['userController', 'create']
        ],
        [
            'info' => 'Registration handler.',
            'requestMethod' => 'post',
            'path' => 'create',
            'callable' => ['userController', 'handleCreate']
        ],
        [
            'info' => 'Edit profile page.',
            'requestMethod' => 'get',
            'path' => 'edit/{id:digit}',
            'callable' => ['userController', 'update']
        ],
        [
            'info' => 'Profile edit handler.',
            'requestMethod' => 'post',
            'path' => 'edit/{id:digit}',
            'callable' => ['userController', 'handleUpdate']
        ],
        [
            'info' => 'Login page.',
            'requestMethod' => 'get',
            'path' => 'login',
            'callable' => ['userController', 'login']
        ],
        [
            'info' => 'Login handler.',
            'requestMethod' => 'post',
            'path' => 'login',
            'callable' => ['userController', 'handleLogin']
        ],
        [
            'info' => 'Logout handler.',
            'requestMethod' => 'get',
            'path' => 'logout',
            'callable' => ['userController', 'handleLogout']
        ]
    ]
];
