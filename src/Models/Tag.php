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
                    'message' => 'Namn måste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 25,
                    'message' => 'Namnet får vara maximalt 25 tecken långt.'
                ]
            ],
            'description' => [
                [
                    'rule' => 'required',
                    'message' => 'Beskrivning måste anges.'
                ],
                [
                    'rule' => 'maxlength',
                    'value' => 200,
                    'message' => 'Beskrivningen får vara maximalt 200 tecken lång.'
                ]
            ]
        ]);
    }
}
