<?php

namespace WGTOTW\Models;

/**
 * Vote model class.
 */
class Vote extends BaseModel
{
    public $id;
    public $postId;
    public $userId;
    public $value;
    
    
    public function __construct()
    {
        $this->setReferences([
            'post' => [
                'attribute' => 'postId',
                'model' => Post::class,
                'magic' => true
            ],
            'user' => [
                'attribute' => 'userId',
                'model' => User::class,
                'magic' => true
            ]
        ]);
    }
}
