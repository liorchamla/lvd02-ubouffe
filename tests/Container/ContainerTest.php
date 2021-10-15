<?php

use App\Container\Container;
use App\Controller\RestaurantsController;
use App\Repository\RestaurantRepository;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function test_it_can_create_an_instance_of_pdo()
    {
        // Given we have a Container and we train it to create a PDO instance 
        $container = new App\Container\Container;

        $container->set(PDO::class, function () {
            return new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        });

        // When we call get method
        $instance = $container->get(PDO::class);

        // Then it gives us an instance of PDO
        $this->assertInstanceOf(PDO::class, $instance);
    }

    public function test_it_can_create_an_instance_with_depencies()
    {
        $container = new Container;

        $container->set(PDO::class, function () {
            return new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        });

        $container->set(RestaurantRepository::class, function (Container $c) {
            $pdo = $c->get(PDO::class);
            return  new RestaurantRepository($pdo);
        });

        $container->set(RestaurantsController::class, function (Container $c) {
            $repository = $c->get(RestaurantRepository::class);

            return new RestaurantsController($repository);
        });

        $instance = $container->get(RestaurantsController::class);

        $this->assertInstanceOf(RestaurantsController::class, $instance);
    }

    public function test_it_does_not_create_multiple_instances()
    {
        $container = new Container;

        $container->set(PDO::class, function () {
            return new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        });

        $pdo1 = $container->get(PDO::class);
        $pdo2 = $container->get(PDO::class);

        $this->assertSame($pdo1, $pdo2);
    }

    // public function test_it_throws_an_exception_if_we_ask_for_an_unexisting_class()
    // {
    //     $container = new Container;

    //     $this->expectException(RuntimeException::class);

    //     $instance = $container->get(PDO::class);
    // }

    public function test_it_can_create_instances_without_specific_factory()
    {
        $container = new Container;

        $container->set(PDO::class, function () {
            return new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        });

        $instance = $container->get(RestaurantsController::class);

        $this->assertInstanceOf(RestaurantsController::class, $instance);
    }
}
