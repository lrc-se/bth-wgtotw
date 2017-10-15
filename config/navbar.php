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
            'route' => 'user'
        ],
        'account' => [
            'title' => 'Konto',
            'route' => null
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
    $navbar['items']['account']['title'] = '<span class="navbar-user">' . htmlspecialchars($user->username) . '</span>';
    $navbar['items']['account']['items'] = [
        [
            'title' => 'Profil',
            'route' => 'user/' . $user->id
        ]
    ];
    if ($user->isAdmin) {
        $navbar['items']['account']['items'][] = [
            'title' => 'Administration',
            'route' => 'admin'
        ];
    }
    $navbar['items']['account']['items'][] = [
        'title' => 'Logga ut',
        'route' => 'account/logout'
    ];
} else {
    $navbar['items']['account']['items'] = [
        [
            'title' => 'Registrera',
            'route' => 'account/create'
        ],
        [
            'title' => 'Logga in',
            'route' => 'account/login'
        ]
    ];
}

return $navbar;
