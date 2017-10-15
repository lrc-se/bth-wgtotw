<?php

/**
 * Navbar config.
 */

// main routes
$navbar = [
    'items' => [
        'start' => [
            'title' => 'Hem',
            'route' => ''
        ],
        'about' => [
            'title' => 'Om',
            'route' => 'about'
        ],
        'questions' => [
            'title' => 'Frågor',
            'route' => 'question'
        ],
        'tags' => [
            'title' => 'Taggar',
            'route' => 'tag'
        ],
        'users' => [
            'title' => 'Användare',
            'route' => null,
            'items' => [
                [
                    'title' => 'Visa alla',
                    'route' => 'user/all'
                ]
            ]
        ]
    ]
];

// handle logged-in user, if any
try {
    $user = $this->di->user->getCurrent();
} catch (Exception $ex) {
    $user = null;
}
if ($user) {
    //$navbar['items']['users']['title'] = '<span class="navbar-user">' . htmlspecialchars($user->username) . '</span>';
    $navbar['items']['users']['items'][] = [
        'title' => 'Profil',
        'route' => 'user/' . $user->id
    ];
    if ($user->isAdmin) {
        $navbar['items']['users']['items'][] = [
            'title' => 'Administration',
            'route' => 'admin'
        ];
    }
    $navbar['items']['users']['items'][] = [
        'title' => 'Logga ut',
        'route' => 'user/logout'
    ];
} else {
    $navbar['items']['users']['items'][] = [
        'title' => 'Skapa konto',
        'route' => 'user/create'
    ];
    $navbar['items']['users']['items'][] = [
        'title' => 'Logga in',
        'route' => 'user/login'
    ];
}

return $navbar;
