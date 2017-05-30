<?php

$container = new Core\Base\Container;

/*
 * Setup container
 */

$container->addService('connection', new Core\Database\Connection);


/*
 * End setup
 */


return $container;