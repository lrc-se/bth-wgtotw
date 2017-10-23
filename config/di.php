<?php

/**
 * DI container config.
 */

// add primary services
$config = [
    'services' => [
        // core
        'request' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\Request\Request())
                    ->init();
            }
        ],
        'response' => [
            'shared' => true,
            'callback' => '\\Anax\\Response\\Response'
        ],
        'url' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\Url\Url())
                    ->setSiteUrl($this->request->getSiteUrl())
                    ->setBaseUrl($this->request->getBaseUrl())
                    ->setStaticSiteUrl($this->request->getSiteUrl())
                    ->setStaticBaseUrl($this->request->getBaseUrl())
                    ->setScriptName($this->request->getScriptName())
                    ->configure('url.php')
                    ->setDefaultsFromConfiguration();
            }
        ],
        'router' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\Route\Router())
                    ->configure('route.php')
                    ->setDI($this);
            }
        ],
        'view' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\View\ViewCollection())
                    ->configure('view.php')
                    ->setDI($this);
            }
        ],
        'viewRenderFile' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\View\ViewRenderFile2())
                    ->setDI($this);
            }
        ],
        'session' => [
            'shared' => true,
            'callback' => function () {
                $session = (new \Anax\Session\SessionConfigurable())
                    ->configure('session.php');
                $session->name();
                $session->start();
                return $session;
            }
        ],
        'textfilter' => [
            'shared' => true,
            'callback' => '\\Anax\\TextFilter\\TextFilter',
        ],
        'db' => [
            'shared' => true,
            'callback' => function () {
                return (new \Anax\Database\DatabaseQueryBuilder())
                    ->configure('db.php');
            }
        ],
        'repository' => [
            'shared' => true,
            'callback' => function () {
                return (new \WGTOTW\Services\RepositoryService())
                    ->inject(['db' => $this->db])
                    ->configure('repositories.php');
            }
        ],
        
        // extensions
        'common' => [
            'shared' => true,
            'callback' => function () {
                return new \WGTOTW\Services\CommonService($this);
            }
        ],
        'user' => [
            'shared' => true,
            'callback' => function () {
                return (new \WGTOTW\Services\UserService())
                    ->inject([
                        'session' => $this->session,
                        'db' => $this->db,
                        'users' => $this->repository->users,
                        'post' => $this->post
                    ]);
            }
        ],
        'post' => [
            'shared' => true,
            'callback' => function () {
                return (new \WGTOTW\Services\PostService())
                    ->inject([
                        'db' => $this->db,
                        'users' => $this->repository->users,
                        'posts' => $this->repository->posts,
                        'tags' => $this->repository->tags,
                        'votes' => $this->repository->votes
                    ]);
            }
        ],
        'tag' => [
            'shared' => true,
            'callback' => function () {
                return (new \WGTOTW\Services\TagService())
                    ->inject([
                        'db' => $this->db,
                        'tags' => $this->repository->tags
                    ]);
            }
        ]
    ]
];


// register controllers
$controllers = [
    'default' => 'Default',
    'error' => 'Error',
    'user' => 'User',
    'question' => 'Question',
    'answer' => 'Answer',
    'comment' => 'Comment',
    'vote' => 'Vote',
    'tag' => 'Tag',
    'admin' => 'Admin',
    'adminUser' => 'AdminUser',
    'adminTag' => 'AdminTag',
    'adminPost' => 'AdminPost'
];

foreach ($controllers as $key => $controller) {
    $class = ($controller[0] != '\\' ? "\\WGTOTW\\Controllers\\$controller" : $controller) . 'Controller';
    $config['services']["{$key}Controller"] = [
        'shared' => true,
        'callback' => function () use ($class) {
            return new $class($this);
        }
    ];
}


return $config;
