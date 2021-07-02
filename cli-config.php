<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

/** @var Container $container */
require_once __DIR__ . '/src/app/app.php';

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));