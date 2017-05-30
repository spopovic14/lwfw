<?php

$container = new Core\Base\Container;

/*
 * Setup container
 */

$container->addService('connection', new Core\Database\Connection);
$container->addService('repositoryManager', (new Core\Database\RepositoryManager($container))->loadRepositories());


/*
 * End setup
 */


return $container;
