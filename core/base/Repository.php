<?php

namespace Core\Base;

class Repository
{
    
    protected $container;
    
    
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function getDb()
    {
        return $this->container->get('connection')->getConnection();
    }
    
}