<?php

namespace WGTOTW\Models;

/**
 * Base model class for posts (questions, answers and comments).
 */
class Post extends BaseModel
{
    public $id;
    public $userId;
    public $parentId;
    public $type;
    public $title;
    public $text;
    public $rank;
    public $status;
    public $published;
    public $updated;
    public $deleted;
    
    
    public function __construct()
    {
        $this->setNullables(['parentId', 'title', 'rank', 'status', 'updated', 'deleted']);
        $this->setReferences([
            'user' => [
                'attribute' => 'userId',
                'model' => User::class,
                'magic' => true
            ]
        ]);
    }
    
    
    /**
     * Return whether the post is an answered question.
     *
     * @return boolean  True if the post is an answered question, false otherwise.
     */
    public function isAnswered()
    {
        return ($this->type == 'question' && $this->status == Question::ANSWERED);
    }
    
    
    /**
     * Return whether the post is an accepted answer.
     *
     * @return boolean  True if the post is an accepted answer, false otherwise.
     */
    public function isAccepted()
    {
        return ($this->type == 'answer' && $this->status == Answer::ACCEPTED);
    }
}
