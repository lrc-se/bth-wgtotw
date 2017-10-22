<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for default pages.
 */
class DefaultController extends BaseController
{
    /**
     * Start page.
     */
    public function index()
    {
        $questions = $this->di->post->useSoft()->getAll('question', ['order' => 'published DESC', 'limit' => 10]);
        $activeUsers = $this->di->db->connect()
            ->select('u.*, COUNT(p.id) AS numPosts')
            ->from($this->di->repository->posts->getCollectionName() . ' AS p')
            ->join($this->di->repository->users->getCollectionName() . ' AS u', 'p.userId = u.id AND u.deleted IS NULL')
            ->where('p.deleted IS NULL')
            ->groupBy('p.userId')
            ->orderBy('numPosts DESC')
            ->limit(5)
            ->execute()
            ->fetchAll();
        $activeTags = $this->di->db->connect()
            ->select('t.*, COUNT(tagId) AS numPosts')
            ->from('wgtotw_post_tag AS pt')
            ->join($this->di->repository->tags->getCollectionName() . ' AS t', 'pt.tagId = t.id')
            ->join($this->di->repository->posts->getCollectionName() . ' AS p', 'pt.postId = p.id')
            ->where('p.deleted IS NULL')
            ->groupBy('pt.tagId')
            ->orderBy('numPosts DESC, t.id')
            ->limit(5)
            ->execute()
            ->fetchAll();
       
        return $this->di->common->renderMain('start', [
            'questions' => $questions,
            'activeUsers' => $activeUsers,
            'activeTags' => $activeTags
        ], null);
    }



    /**
     * About page.
     */
    public function about()
    {
        return $this->di->common->renderMain('about', [], 'Om webbplatsen');
    }
}
