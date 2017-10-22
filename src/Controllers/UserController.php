<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for users.
 */
class UserController extends BaseController
{
    /**
     * User index.
     */
    public function index()
    {
        return $this->di->common->renderMain('user/index', [
            'users' => $this->di->repository->users->getAllSoft()
        ], 'Användare');
    }
    
    
    /**
     * Profile page.
     *
     * @param int|Models\User   $id     User ID or user model instance.
     */
    public function profile($id)
    {
        $user = ($id instanceof Models\User ? $id : $this->di->user->useSoft()->getById($id));
        if (!$user) {
            $this->di->common->redirectError('user/all', "Kunde inte hitta användaren med ID $id.");
        }
        
        return $this->di->common->renderMain('user/profile', [
            'user' => $user,
            'reputation' => $this->di->user->getReputation($user),
            'numVotes' => $this->di->repository->votes->count('userId = ?', [$user->id]),
            'questions' => $this->di->post->useSoft()->getByAuthor($user, 'question', ['order' => 'published DESC']),
            'answers' => $this->di->post->useSoft()->getByAuthor($user, 'answer', ['order' => 'published DESC']),
            'comments' => $this->di->post->useSoft()->getByAuthor($user, 'comment', ['order' => 'published DESC']),
            'curUser' => $this->di->user->getCurrent()
        ], htmlspecialchars($user->username));
    }
    
    
    /**
     * Profile page (logged-in user).
     */
    public function profile2()
    {
        $user = $this->di->user->getCurrent();
        if (!$user) {
            $this->di->common->redirect('user/login');
        }
        
        return $this->profile($user);
    }
    
    
    /**
     * Registration page.
     */
    public function create()
    {
        return $this->di->common->renderMain('user/form', [
            'user' => null,
            'admin' => null,
            'update' => false,
            'form' => new Form('user-form', Models\User::class),
            'title' => 'Skapa konto'
        ], 'Skapa konto');
    }
    
    
    /**
     * Registration handler.
     */
    public function handleCreate()
    {
        $form = new Form('user-form', Models\User::class);
        if ($this->di->user->createFromForm($form)) {
            $user = $form->getModel();
            $this->di->session->set('userId', $user->id);
            $this->di->common->redirectMessage('user/' . $user->id, 'Ditt användarkonto har skapats.');
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => null,
            'update' => false,
            'form' => $form,
            'title' => 'Skapa konto'
        ], 'Skapa konto');
    }
    
    
    /**
     * Edit profile page.
     *
     * @param int $id   User ID.
     */
    public function update($id)
    {
        $user = $this->di->common->verifyUser();
        if ($user->id != $id) {
            $this->di->common->redirectError('user/' . $user->id, 'Du har inte behörighet att redigera den begärda profilen.');
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $user,
            'admin' => null,
            'update' => true,
            'form' => new Form('user-form', $user),
            'title' => 'Redigera profil'
        ], 'Redigera profil');
    }
    
    
    /**
     * Edit profile handler.
     *
     * @param int $id   User ID.
     */
    public function handleUpdate($id)
    {
        $oldUser = $this->di->common->verifyUser();
        if ($oldUser->id != $id) {
            $this->di->common->redirectError('user/' . $oldUser->id, 'Du har inte behörighet att redigera den begärda profilen.');
        }
        
        $form = new Form('user-form', Models\User::class);
        if ($this->di->user->updateFromForm($form, $oldUser)) {
            //$this->di->session->set('msg', 'Din profil har uppdaterats.');
            $this->di->common->redirect('user/' . $oldUser->id);
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => null,
            'update' => true,
            'form' => $form,
            'title' => 'Redigera profil'
        ], 'Redigera profil');
    }
    
    
    /**
     * Login page.
     */
    public function login()
    {
        $returnUrl = $this->di->session->getOnce('returnUrl');
        $user = $this->di->user->getCurrent();
        if ($user) {
            $this->di->common->redirect('user/' . $user->id);
        }
        
        return $this->di->common->renderMain('user/login', ['returnUrl' => $returnUrl], 'Logga in');
    }
    
    
    /**
     * Login handler.
     */
    public function handleLogin()
    {
        $username = $this->di->request->getPost('username', '');
        $password = $this->di->request->getPost('password', '');
        if ($username === '' || $password === '' || !$this->di->user->login($username, $password)) {
            $this->di->common->redirectError('user/login', 'Felaktigt användarnamn eller lösenord.');
        }
        $this->di->common->redirect($this->di->request->getPost('url', 'user/' . $this->di->user->getCurrent()->id));
    }
    
    
    /**
     * Logout handler.
     */
    public function handleLogout()
    {
        if ($this->di->user->getCurrent()) {
            $this->di->user->logout();
            $this->di->session->set('msg', 'Du har loggats ut.');
        }
        $this->di->common->redirect('user/login');
    }
}
