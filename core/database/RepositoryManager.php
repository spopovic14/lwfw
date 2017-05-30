<?php

namespace Core\Database;

class RepositoryManager
{
    
    protected $repositories;
    protected $container;
    
    
    public function __construct($container)
    {
        $this->repositories = [];
        $this->container = $container;
    }
    
    public function loadRepositories()
    {
        $repositoryDir = BASE_DIR . 'app/Repository/';
        $basePath =  'App\\Repository\\';
        
        foreach(scandir($repositoryDir) as $file)
        {
            $path = $repositoryDir . $file;
            if(!is_dir($path))
            {
                $className = str_replace('.php', '', $file);
                $simpleName = str_replace('Repository', '', $className);
                $className = $basePath . $className;
                $instance = new $className($this->container);
                $this->addRepository($simpleName, $instance);
            }
        }
        return $this;
    }
    
    public function getRepository($model)
    {
        if(array_key_exists($model, $this->repositories))
        {
            return $this->repositories[$model];
        }
        return null;
    }
    
    protected function addRepository($name, $repository)
    {
        $this->repositories[$name] = $repository;
    }
    
}