<?php

namespace WGTOTW\Services;

use \Anax\DI as DI;

/**
 * Base class for services.
 */
class BaseService
{
    /**
     * @var DI\DIInterface  DI container.
     */
    protected $di;
    
    /**
     * @var boolean     Whether the DI container is local to the service.
     */
    private $localDI;
    
    
    /**
     * Constructor.
     *
     * @param DI\DIInterface    $di     Non-local DI container reference, if any.
     */
    public function __construct($di = null)
    {
        $this->localDI = is_null($di);
        $this->di = ($this->localDI ? new DISimple() : $di);
    }
    
    
    /**
     * Inject dependencies.
     * 
     * @param array $dependencies       Array of dependencies to inject.
     *
     * @throws DI\Exception\Exception   If the DI container is non-local.
     *
     * @return self
     */
    public function inject($dependencies)
    {
        if (!$this->localDI) {
            throw new DI\Exception\Exception('Cannot add service-level dependencies to non-local DI container.');
        }
        foreach ($dependencies as $name => $dep) {
            $this->di->add($name, $dep);
        }
        return $this;
    }
}
