<?php

/**
 * Internal routes for error handling.
 */

return [
    'routes' => [
        [
            'info' => '403 Forbidden',
            'internal' => true,
            'path' => '403',
            'callable' => function () {
                $this->di->errorController->defaultError(403);
            }
        ],
        [
            'info' => '404 Not Found',
            'internal' => true,
            'path' => '404',
            'callable' => function () {
                $this->di->errorController->defaultError(404);
            }
        ],
        [
            'info' => '500 Internal Server Error',
            'internal' => true,
            'path' => '500',
            'callable' => function () {
                $this->di->errorController->defaultError(500);
            }
        ]
    ]
];
