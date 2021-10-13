<?php

use PHPUnit\Framework\TestCase;

class RestaurantsControllerTest extends TestCase {
    public function test_it_shows_restaurants() {
        $controller = new App\Controller\RestaurantsController;

        $response = $controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString("<h1>Restaurants</h1>", $response->getContent());
    }
}