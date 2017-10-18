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
        $questions = $this->di->post->useSoft()->getAll('question', 'published DESC');
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
        
        return $this->di->common->renderMain('start', [
            'questions' => $questions,
            'activeUsers' => $activeUsers
        ], 'Start');
    }
}
