<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Models as Models;
use \WGTOTW\Form\ModelForm as Form;

/**
 * Controller for admin.
 */
class AdminController extends BaseController
{
    /**
     * Admin start page.
     */
    public function index()
    {
        $this->di->common->verifyAdmin();
        return $this->di->common->renderMain('admin/index', [], 'Administration');
    }
    
    
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
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($form->getModel()->username) . '" har skapats.');
            }
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => false,
            'form' => $form
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
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($form->getModel()->username) . '" har uppdaterats.');
            }
        } else {
            $form = new Form('user-form', $user);
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => true,
            'form' => new Form('user-form', $user)
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
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($user->username) . '" har tagits bort.');
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
            $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($user->username) . '" har återställts.');
        }
        
        $this->di->common->redirect('admin/user');
    }
}
