<?php

namespace WGTOTW\Models;

/**
 * Comment model class.
 */
class Comment extends Post
{
    public function __construct()
    {
        parent::__construct();
        $this->type = 'comment';
        $this->setValidation([
            'text' => [
                [
                    'rule' => 'required',
                    'message' => 'Kommentarstexten får inte vara tom.'
                ]
            ]
        ]);
    }
}
