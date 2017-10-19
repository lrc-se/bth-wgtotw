<?php

namespace WGTOTW\Services;

use \WGTOTW\Models as Models;

/**
 * User service.
 */
class UserService extends BaseService
{
    /**
     * @var Models\User     Current logged-in user.
     */
    private $curUser = null;
    
    /**
     * @var boolean     Whether to take soft-deletion into account for selection queries.
     */
    private $softQuery = false;
    
    
    /**
     * Get a user by ID.
     *
     * @param int $id       User ID.
     *
     * @return Models\User|null    User model instance if found, null otherwise.
     */
    public function getById($id)
    {
        $method = ($this->softQuery ? 'findSoft' : 'find');
        $user = ($this->di->users->$method(null, $id) ?: null);
        $this->useSoft(false);
        return $user;
    }
    
    
    /**
     * Get a user by username.
     *
     * @param string $username  Username.
     *
     * @return Models\User|null        User model instance if found, null otherwise.
     */
    public function getByUsername($username)
    {
        $method = ($this->softQuery ? 'findSoft' : 'find');
        $user = ($this->di->users->$method('username', $username) ?: null);
        $this->useSoft(false);
        return $user;
    }
    
    
    /**
     * Get the currently logged-in user, if any.
     * 
     * @return Models\User|null    User model instance if found, null otherwise.
     */
    public function getCurrent()
    {
        if (!$this->curUser && $this->di->session->has('userId')) {
            $this->curUser = $this->useSoft()->getById($this->di->session->get('userId'));
        }
        return $this->curUser;
    }
    
    
    /**
     * Get user reputation.
     *
     * @param Models\User   $user   User model instance.
     *
     * @return int                  User reputation level.
     */
    public function getReputation($user)
    {
        $rep = 0;
        $posts = $this->di->post->useSoft()->getByAuthor($user);
        foreach ($posts as $post) {
            if ($post->rank < 0) {
                $factor = $post->rank - 1;
            } elseif ($post->rank > 0) {
                $factor = $post->rank + 1;
            } else {
                $factor = 1;
            }
            switch ($post->type) {
                case 'question':
                    $rep += 2 * $factor;
                    break;
                case 'answer':
                    $rep += ($post->isAccepted() ? 5 : 3) * $factor;
                    break;
                case 'comment':
                    $rep += $factor;
                    break;
            }
        }
        return $rep;
    }
    
    
    /**
     * Create user from model-bound form.
     *
     * @param \LRC\Form\ModelForm   $form       Model-bound form.
     * @param boolean               $admin      Whether the creation is performed by an admin.
     *
     * @return bool                             True if the insert was performed, false if validation failed.
     */
    public function createFromForm($form, $admin = false)
    {
        $user = $form->populateModel();
        $form->validate();
        if ($user->password !== $form->getExtra('password2')) {
            $form->addError('password', 'Lösenorden stämmer inte överens.');
            $form->addError('password2', 'Lösenorden stämmer inte överens.');
        }
        if ($this->getByUsername($user->username)) {
            $form->addError('username', 'Användarnamnet är upptaget.');
        }
        
        if ($form->isValid()) {
            if (!$admin) {
                $user->isAdmin = false;
            }
            $user->hashPassword();
            $user->hideEmail = (bool)$user->hideEmail;
            $user->created = date('Y-m-d H:i:s');
            $this->di->users->save($user);
            return true;
        }
        return false;
    }
    
    
    /**
     * Update user from model-bound form.
     *
     * @param \LRC\Form\ModelForm   $form       Model-bound form.
     * @param User                  $oldUser    Model instance of existing user.
     * @param boolean               $admin      Whether the update is performed by an admin.
     *
     * @return bool                             True if the update was performed, false if validation failed.
     */
    public function updateFromForm($form, $oldUser, $admin = false)
    {
        $user = $form->populateModel();
        $user->id = $oldUser->id;
        $user->username = $oldUser->username;
        if ($user->password === '') {
            $user->password = $oldUser->password;
            $form->validate();
        } else {
            $form->validate();
            if ($user->password === $form->getExtra('password2')) {
                $user->hashPassword();
            } else {
                $form->addError('password', 'Lösenorden stämmer inte överens.');
                $form->addError('password2', 'Lösenorden stämmer inte överens.');
            }
        }
        
        if ($form->isValid()) {
            if (!$admin) {
                $user->isAdmin = false;
            }
            $user->hideEmail = (bool)$user->hideEmail;
            $user->created = $oldUser->created;
            $user->updated = date('Y-m-d H:i:s');
            $this->di->users->save($user);
            return true;
        }
        return false;
    }
    
    
    /**
     * Delete a user.
     *
     * @param Models\User $user    User model instance.
     */
    public function delete($user)
    {
        $this->di->users->deleteSoft($user);
    }
    
    
    /**
     * Restore a deleted user.
     *
     * @param Models\User $user    User model instance.
     */
    public function restore($user)
    {
        $this->di->users->restoreSoft($user);
    }
    
    
    /**
     * Attempt to log in a user.
     *
     * @param string $username  Username.
     * @param string $password  Password.
     *
     * @return bool             True if login was successful, false otherwise.
     */
    public function login($username, $password)
    {
        $user = $this->useSoft()->getByUsername($username);
        if ($user && $user->verifyPassword($password)) {
            $this->di->session->set('userId', $user->id);
            return true;
        }
        return false;
    }
    
    
    /**
     * Log out the current user.
     */
    public function logout()
    {
        $this->di->session->delete('userId');
        $this->curUser = null;
    }
    
    
    /**
     * Set whether to take soft-deletion into account for the next selection query.
     *
     * @param boolean   $state  True = on, false = off.
     *
     * @return self
     */
    public function useSoft($state = true)
    {
        $this->softQuery = $state;
        return $this;
    }
}
