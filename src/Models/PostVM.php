<?php

namespace WGTOTW\Models;

/**
 * Post view model including username.
 */
class PostVM extends Post
{
    public $username;
    
    
    public function __construct()
    {
        // override base constructor
    }
}
