<?php

namespace WGTOTW\Services;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;

/**
 * Application-wide database repository service.
 */
class RepositoryService extends BaseService implements ConfigureInterface
{
    use ConfigureTrait {
        configure as loadConfig;
    }
    
    
    /**
     * @var \LRC\Repository\RepositoryManager   Repository manager.
     */
    public $manager;
    
    /**
     * @var array   Loaded repositories.
     */
    private $repositories;
    
    
    /**
     * Constructor.
     *
     * @param \Anax\DI\DIInterface  $di     Non-local DI container reference, if any (see base class).
     */
    public function __construct($di = null)
    {
        parent::__construct($di);
        $this->manager = new \LRC\Repository\RepositoryManager();
    }
    
    
    /**
     * Configure service with config file, loading repositories defined therein.
     *
     * @return self
     */
    public function configure($file)
    {
        $this->loadConfig($file);
        foreach ($this->config['repositories'] as $name => $config) {
            $config['db'] = $this->di->db;
            $this->add($name, $config);
        }
        return $this;
    }
    
    
    /**
     * Add repository.
     *
     * @param string    $name   Repository name to expose as property.
     * @param array     $config Repository configuration.
     */
    public function add($name, $config)
    {
        $this->repositories[$name] = $this->manager->createRepository($name, $config);
    }
    
    
    /**
     * Accessor method to retrieve repository by name.
     *
     * @param   string                              $name   Repository name.
     *
     * @return  \LRC\Repository\RepositoryInterface|null    The loaded repository matching the name, or null if no match.
     */
    public function __get($name)
    {
        return (isset($this->repositories[$name]) ? $this->repositories[$name] : null);
    }
}
