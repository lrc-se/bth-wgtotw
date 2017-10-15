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
                    'message' => 'Rubrik måste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 100,
                    'message' => 'Rubriken får vara maximalt 100 tecken lång.'
                ]
            ],
            'text' => [
                [
                    'rule' => 'required',
                    'message' => 'Frågetexten får inte vara tom.'
                ]
            ]
        ]);
    }
}
