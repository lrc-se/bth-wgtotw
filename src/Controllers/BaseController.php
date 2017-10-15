<?php

namespace WGTOTW\Controllers;

/**
 * Base class for controllers.
 */
class BaseController
{
    /**
     * @var \Anax\DI\DIInterface    Reference to DI container.
     */
    protected $di;
    
    
    /**
     * Constructor.
     * 
     * @param \Anax\DI\DIInterface  $di     Reference to DI container.
     */
    public function __construct($di)
    {
        $this->di = $di;
    }
}
