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
}
