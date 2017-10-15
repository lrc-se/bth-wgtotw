<?php

/**
 * Repository config.
 */

return [
    'repositories' => [
        'users' => [
            'type' => 'db-soft',
            'table' => 'user',
            'model' => \WGTOTW\Models\User::class
        ],
        'posts' => [
            'type' => 'db-soft',
            'table' => 'post',
            'model' => \WGTOTW\Models\Post::class
        ],
        'tags' => [
            'type' => 'db',
            'table' => 'tag',
            'model' => \WGTOTW\Models\Tag::class
        ],
        'votes' => [
            'type' => 'db',
            'table' => 'vote',
            'model' => \WGTOTW\Models\Vote::class
        ]
    ]
];
