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
            if ($this->di->user->createFromForm($form)) {
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
            if ($this->di->user->updateFromForm($form, $user)) {
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($form->getModel()->username) . '" har uppdaterats.');
            }
        } else {
            $form = new Form('user-form', $user);
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => true,
            'form' => $form
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
    
    
    
    /**
     * Admin tag list.
     */
    public function tags()
    {
        $this->di->common->verifyAdmin();
        $tags = $this->di->repository->tags->getAll();
        
        return $this->di->common->renderMain('admin/tag-list', [
            'tags' => $tags
        ], 'Administrera taggar');
    }
    
    
    /**
     * Admin create tag page/handler.
     */
    public function createTag()
    {
        $this->di->common->verifyAdmin();
        $form = new Form('tag-form', Models\Tag::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->tag->createFromForm($form)) {
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($form->getModel()->name) . '" har skapats.');
            }
        }
        
        return $this->di->common->renderMain('tag/form', [
            'tag' => $form->getModel(),
            'update' => false,
            'form' => $form
        ], 'Skapa tagg');
    }
    
    
    /**
     * Admin edit tag page/handler.
     *
     * @param int $id   Tag ID.
     */
    public function updateTag($id)
    {
        $this->di->common->verifyAdmin();
        $tag = $this->di->tag->getById($id);
        if (!$tag) {
            $this->di->common->redirectError('admin/tag', "Kunde inte hitta taggen med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('tag-form', Models\Tag::class);
            if ($this->di->tag->updateFromForm($form, $tag)) {
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($form->getModel()->name) . '" har uppdaterats.');
            }
        } else {
            $form = new Form('tag-form', $tag);
        }
        
        return $this->di->common->renderMain('tag/form', [
            'tag' => $form->getModel(),
            'update' => true,
            'form' => $form
        ], 'Redigera tagg');
    }
    
    
    /**
     * Admin delete tag page/handler.
     *
     * @param int $id   Tag ID.
     */
    public function deleteTag($id)
    {
        $this->di->common->verifyAdmin();
        $tag = $this->di->tag->getById($id);
        if (!$tag) {
            $this->di->common->redirectError('admin/tag', "Kunde inte hitta taggen med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->tag->delete($tag);
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($tag->name) . '" har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/tag-delete', ['tag' => $tag], 'Ta bort tagg');
    }
    
    
    
    /**
     * Admin question list.
     */
    public function questions()
    {
        $this->di->common->verifyAdmin();
        
        $status = $this->di->request->getGet('status');
        if ($status == 'active') {
            $questions = $this->di->post->useSoft()->getByType('question');
            $total = $this->di->repository->posts->count("type = 'question'");
        } elseif ($status == 'inactive') {
            $questions = $this->di->repository->posts->getAll("type = 'question' AND deleted IS NOT NULL");
            $total = $this->di->repository->posts->count("type = 'question'");
        } else {
            $questions = $this->di->post->getByType('question');
            $total = count($questions);
        }
        
        return $this->di->common->renderMain('admin/question-list', [
            'questions' => $questions,
            'total' => $total,
            'status' => $status
        ], 'Administrera frågor');
    }
    
    
    /**
     * Admin edit post page/handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function updatePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        list($words, $model) = $this->getPostMeta($type);
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError("admin/$type", 'Kunde inte hitta ' . $words[1] . " med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form("$type-form", $model);
            if ($this->di->post->updateFromForm($form, $post)) {
                $this->di->common->redirectMessage("admin/$type", ucfirst($words[1]) . ' har uppdaterats.');
            }
        } else {
            $form = new Form("$type-form", $post);
        }
        
        switch ($type) {
            case 'question':
                return $this->di->common->renderMain('question/form', [
                    'question' => $form->getModel(),
                    'admin' => true,
                    'update' => true,
                    'form' => $form,
                    'tags' => $this->di->tag->getAll(),
                    'tagIds' => $this->di->tag->getIdsByPost($post)
                ], 'Redigera fråga');
            case 'answer':
                break;
            case 'comment':
                break;
        }
    }
    
    
    /**
     * Admin delete post page/handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function deletePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        list($words, $model) = $this->getPostMeta($type);
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError("admin/$type", 'Kunde inte hitta ' . $words[1] . " med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->post->delete($post);
                $this->di->common->redirectMessage("admin/$type", ucfirst($words[1]) . ' har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/post-delete', ['post' => $post, 'type' => $type], 'Ta bort ' . $words[0]);
    }
    
    
    /**
     * Admin restore post handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function restorePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        list($words, $model) = $this->getPostMeta($type);
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError("admin/$type", 'Kunde inte hitta ' . $words[1] . " med ID $id.");
        }
        
        if ($this->di->request->getPost('action') == 'restore') {
            $this->di->post->restore($post);
            $this->di->common->redirectMessage("admin/$type", ucfirst($words[1]) . ' har återställts.');
        }
        
        $this->di->common->redirect("admin/$type");
    }
    
    
    /**
     * Get post metadata by type.
     *
     * @param string $type  Post type.
     *
     * @return array        Array of natural-language designations and model class for the post type.
     */
    private function getPostMeta($type)
    {
        switch ($type) {
            case 'question':
                $words = ['fråga', 'frågan'];
                $model = Models\Question::class;
                break;
            case 'answer':
                $words = ['svar', 'svaret'];
                $model = Models\Answer::class;
                break;
            case 'comment':
                $words = ['kommentar', 'kommentaren'];
                $model = Models\Comment::class;
                break;
            default:
                $words = null;
                $model = null;
        }
        return [$words, $model];
    }
}
