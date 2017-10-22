<?php

namespace WGTOTW\Models;

/**
 * Answer model class.
 */
class Answer extends Post
{
    /**
     * @const string    Accepted status.
     */
    const ACCEPTED = 'accepted';
    
    
    public function __construct()
    {
        parent::__construct();
        $this->type = 'answer';
        $this->setValidation([
            'text' => [
                [
                    'rule' => 'required',
                    'message' => 'Svarstexten får inte vara tom.'
                ]
            ]
        ]);
    }
}
