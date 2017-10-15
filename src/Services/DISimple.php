<?php

namespace WGTOTW\Services;

use \Anax\DI as DI;

/**
 * Simple container for injected dependency references (no loading).
 */
class DISimple implements DI\DIInterface
{
    use DI\DIMagicTrait;
    
    
    /**
     * @var array   Dependency references.
     */
    private $refs = [];
    
    
    /**
     * Add dependency.
     * 
     * @param string    $name       Dependency name.
     * @param mixed     $dependency Dependency reference.
     */
    public function add($name, $dependency)
    {
        $this->refs[$name] = $dependency;
    }
    
    
    /**
     * Get dependency by name.
     *
     * @param string $name                      Dependency name.
     *
     * @throws DI\Exception\NotFoundException   If the dependency was not found.
     *
     * @return mixed                            Dependency reference.
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new DI\Exception\NotFoundException("The service '$name' is not loaded in the DI container.");
        }
        return $this->refs[$name];
    }
    
    
    /**
     * Return whether a dependency by the given name exists in the container.
     *
     * @param string    $name   Dependency name.
     *
     * @return boolean          True if the dependency was found, false otherwise.
     */
    public function has($name)
    {
        return isset($this->refs[$name]);
    }
}
