<?php

/**
 * Repository config.
 */

return [
    'repositories' => [
        'users' => [
            'type' => 'db-soft',
            'table' => 'wgtotw_user',
            'model' => \WGTOTW\Models\User::class
        ],
        'posts' => [
            'type' => 'db-soft',
            'table' => 'wgtotw_post',
            'model' => \WGTOTW\Models\Post::class
        ],
        'tags' => [
            'type' => 'db',
            'table' => 'wgtotw_tag',
            'model' => \WGTOTW\Models\Tag::class
        ],
        'votes' => [
            'type' => 'db',
            'table' => 'wgtotw_vote',
            'model' => \WGTOTW\Models\Vote::class
        ]
    ]
];
