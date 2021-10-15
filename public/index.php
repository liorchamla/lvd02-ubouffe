<?php

use App\Container\Container;
use App\Controller\HelloController;
use App\Controller\RestaurantsController;
use App\Http\Request;
use App\Repository\RestaurantRepository;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container;

$container->set(PDO::class, function () {
    return new PDO("mysql:host=localhost;dbname=ubouffe;charset=utf8", "root", "root");
});


$routes = new RouteCollection;

$routes->add('home', new Route("/", [
    'controller' => "App\Controller\RestaurantsController@index"
]));
$routes->add('hello', new Route("/hello", [
    'controller' => "App\Controller\HelloController@hello"
]));

$requestContext = new RequestContext();

$matcher = new UrlMatcher($routes, $requestContext);

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

$test = $matcher->match($pathInfo);

$controller = $test['controller']; // Chaine de caractère NOMDELACLASSE@NOMDELAMETHODE

$parts = explode("@", $controller);

[$className, $methodName] = $parts;

$instance = $container->get($className);
$callable = [$instance, $methodName];

$request = new Request($_GET);

$response = $callable($request);

$response->send();
