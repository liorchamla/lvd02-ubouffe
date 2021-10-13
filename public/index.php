<?php

use App\Controller\HelloController;
use App\Http\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$request = new Request($_GET);

$controller = new HelloController;

$response = $controller->hello($request);

$response->send();