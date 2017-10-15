<?php

namespace WGTOTW\Models;

/**
 * Question model class.
 */
class Question extends Post
{
    /**
     * @const string    Answered status.
     */
    const ANSWERED = 'answered';
    
    
    public function __construct()
    {
        parent::__construct();
        $this->type = 'question';
        $this->setValidation([
            'title' => [
                [
                    'rule' => 'required',
                    'message' => 'Rubrik m�ste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 100,
                    'message' => 'Rubriken f�r vara maximalt 100 tecken l�ng.'
                ]
            ],
            'text' => [
                [
                    'rule' => 'required',
                    'message' => 'Fr�getexten f�r inte vara tom.'
                ]
            ]
        ]);
    }
}
