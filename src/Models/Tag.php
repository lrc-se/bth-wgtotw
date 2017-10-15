<?php

namespace WGTOTW\Models;

/**
 * Tag model class.
 */
class Tag extends BaseModel
{
    public $id;
    public $postId;
    public $name;
    public $description;
    public $created;
    public $updated;
    
    
    public function __construct()
    {
        $this->setNullables(['updated']);
        $this->setReferences([
            'post' => [
                'attribute' => 'postId',
                'model' => Post::class,
                'magic' => true
            ]
        ]);
        $this->setValidation([
            'name' => [
                [
                    'rule' => 'required',
                    'message' => 'Namn m�ste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 25,
                    'message' => 'Namnet f�r vara maximalt 25 tecken l�ngt.'
                ]
            ],
            'description' => [
                [
                    'rule' => 'required',
                    'message' => 'Beskrivning m�ste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 200,
                    'message' => 'Beskrivningen f�r vara maximalt 200 tecken l�ng.'
                ]
            ]
        ]);
    }
}
