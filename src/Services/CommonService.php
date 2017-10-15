<?php

namespace WGTOTW\Services;

/**
 * Common framework resources.
 */
class CommonService extends BaseService
{
    /**
     * @var array   Flash messages.
     */
    private $messages;
    
    
    /**
     * Redirect to URL.
     *
     * @param string $url   URL to redirect to.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function redirect($url)
    {
        $this->di->response->redirect($this->di->url->create($url));
        exit;
    }
    
    
    /**
     * Retrieve flash messages from session.
     */
    public function retrieveMessages($labels = ['msg', 'err'])
    {
        foreach ($labels as $label) {
            $this->messages[$label] = $this->di->session->getOnce($label);
        }
    }
    
    
    /**
     * Return flash message.
     *
     * @param string $label     Message label.
     *
     * @return string|null      The requested message, or null if no message found.
     */
    public function getMessage($label = 'msg')
    {
        return (array_key_exists($label, $this->messages) ? $this->messages[$label] : null);
    }
    
    
    /**
     * Verify that there is a logged-in user.
     *
     * @param string        $url    Url to redirect to if verification fails.
     * @param bool          $admin  Whether to require admin status as well.
     *
     * @return \WGTOTW\Models\User  Model instance of the logged-in user.
     */
    public function verifyUser($url = 'account/login', $admin = false)
    {
        $user = $this->di->user->getCurrent();
        if (!$user) {
            $error = 'Du måste logga in för att kunna se den begärda sidan.';
        } elseif ($admin && !$user->isAdmin) {
            $error = 'Du måste logga in som administratör för att kunna se den begärda sidan.';
        }
        
        if (!empty($error)) {
            $this->di->session->set('err', $error);
            $this->di->session->set('returnUrl', $this->di->request->getCurrentUrl());
            $this->redirect($url);
        }        
        return $user;
    }
    
    
    /**
     * Verify that there is a logged-in user with admin status.
     *
     * @param string    $url    Url to redirect to if verification fails.
     *
     * @return \LRC\User\User   Model instance of the logged-in user.
     */
    public function verifyAdmin($url = 'account/login')
    {
        return $this->verifyUser($url, true);
    }
    
    
    /**
     * Render a standard web page using a specific layout.
     *
     * @param string    $title      Page title.
     * @param string    $content    Page content.
     * @param array     $data       View data.
     * @param int       $status     HTTP status code.
     *
     * @return true
     */
    public function renderPage($title, $content = '', $data = [], $status = 200)
    {
        $data['stylesheets'] = ['css/style.css'];
        
        // retrieve flash messages, if any
        $this->retrieveMessages();

        // common header and footer
        $navbar = (new NavbarService($this->di))
            ->configure('navbar.php');
        $this->di->view->add('default/header', ['navbar' => $navbar], 'header');
        $this->di->view->add('default/footer', [], 'footer');
        
        // content
        if (!is_null($content)) {
            $this->di->view->add('default/main', ['content' => $content]);
        }
        
        // render layout
        if (!isset($data['title'])) {
            $data['title'] = $title;
        }
        $this->di->view->add('default/layout', $data, 'layout');
        $body = $this->di->view->renderBuffered('layout');
        $this->di->response->setBody($body)->send($status);
        
        return true;
    }


    /**
     * Convenience method to render main region in standard page.
     *
     * @param string    $view   View template.
     * @param array     $data   View data.
     * @param string    $title  View title.
     *
     * @return true
     */
    public function renderMain($view, $data, $title)
    {
        $this->di->view->add($view, $data, 'main');
        return $this->renderPage($title);
    }
}
