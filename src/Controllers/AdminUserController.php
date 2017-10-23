<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Models as Models;
use \WGTOTW\Form\ModelForm as Form;

/**
 * Controller for admin user functions.
 */
class AdminUserController extends BaseController
{
    /**
     * Admin user list.
     */
    public function users()
    {
        $admin = $this->di->common->verifyAdmin();
        
        $status = $this->di->request->getGet('status');
        if ($status == 'active') {
            $users = $this->di->repository->users->getAllSoft();
            $total = $this->di->repository->users->count();
        } elseif ($status == 'inactive') {
            $users = $this->di->repository->users->getAll('deleted IS NOT NULL');
            $total = $this->di->repository->users->count();
        } else {
            $users = $this->di->repository->users->getAll();
            $total = count($users);
        }
        
        return $this->di->common->renderMain('admin/user-list', [
            'users' => $users,
            'admin' => $admin,
            'total' => $total,
            'status' => $status
        ], 'Administrera användare');
    }
    
    
    /**
     * Admin create user page/handler.
     */
    public function createUser()
    {
        $admin = $this->di->common->verifyAdmin();
        $form = new Form('user-form', Models\User::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->user->createFromForm($form, true)) {
                $this->di->common->redirectMessage('admin/user', 'Användaren <strong>' . htmlspecialchars($form->getModel()->username) . '</strong> har skapats.');
            }
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => false,
            'form' => $form,
            'title' => 'Skapa användare'
        ], 'Skapa användare');
    }
    
    
    /**
     * Admin edit user page/handler.
     *
     * @param int $id   User ID.
     */
    public function updateUser($id)
    {
        $admin = $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('user-form', Models\User::class);
            if ($this->di->user->updateFromForm($form, $user, true)) {
                $this->di->common->redirectMessage('admin/user', 'Användaren <strong>' . htmlspecialchars($form->getModel()->username) . '</strong> har uppdaterats.');
            }
        } else {
            $form = new Form('user-form', $user);
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => true,
            'form' => $form,
            'title' => 'Redigera användare'
        ], 'Redigera användare');
    }
    
    
    /**
     * Admin delete user page/handler.
     *
     * @param int $id   User ID.
     */
    public function deleteUser($id)
    {
        $admin = $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        if ($user->id == $admin->id) {
            $this->di->common->redirectError('admin/user', 'Du kan inte ta bort din egen användare.');
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->user->delete($user);
                $this->di->common->redirectMessage('admin/user', 'Användaren <strong>' . htmlspecialchars($user->username) . '</strong> har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/user-delete', ['user' => $user], 'Ta bort användare');
    }
    
    
    /**
     * Admin restore user handler.
     *
     * @param int $id   User ID.
     */
    public function restoreUser($id)
    {
        $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        
        if ($this->di->request->getPost('action') == 'restore') {
            $this->di->user->restore($user);
            $this->di->common->redirectMessage('admin/user', 'Användaren <strong>' . htmlspecialchars($user->username) . '</strong> har återställts.');
        }
        
        $this->di->common->redirect('admin/user');
    }
}
