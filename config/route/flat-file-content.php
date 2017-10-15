<?php

/**
 * Routes for flat file content.
 */

return [
    'routes' => [
        [
            'info' => 'Render flat file content.',
            'requestMethod' => null,
            'path' => null,
            'callable' => ['contentController', 'defaultView']
        ]
    ]
];
