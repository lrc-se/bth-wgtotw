<?php

namespace WGTOTW\Models;

/**
 * Post view model including user data.
 */
class PostVM extends Post
{
    public $username;
    public $email;
    
    
    public function __construct()
    {
        // override base constructor
    }
}
