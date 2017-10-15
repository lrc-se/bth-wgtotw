<?php

/**
 * Default route to create a 404, if no other route matched.
 */

return [
    'routes' => [
        [
            'info' => 'Catch unmatched routes and send 404.',
            'requestMethod' => null,
            'path' => null,
            'callable' => function () {
                throw new \Anax\Route\Exception\NotFoundException();
            }
        ]
    ]
];
