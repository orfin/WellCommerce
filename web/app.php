<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader       = require __DIR__ . '/../app/autoload.php';
include_once __DIR__.'/../app/bootstrap.php.cache';

//$cachedLoader = new ApcClassLoader(sha1(__FILE__), $loader);
//$cachedLoader->register();
//$loader->unregister();

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
$request  = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
