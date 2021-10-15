<?php

use App\Dto\Restaurant;
use App\Repository\RestaurantRepository;
use PHPUnit\Framework\TestCase;

class RestaurantsControllerTest extends TestCase
{
    public function test_it_shows_restaurants()
    {
        // Given we have 3 restaurants (Etant donnée qu'on a 3 restaurants)
        $pdo = new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        $pdo->query('DELETE FROM restaurant');

        $repo = new RestaurantRepository($pdo);

        for ($i = 0; $i < 3; $i++) {
            $restaurant = new Restaurant;
            $restaurant->title = "Title $i";
            $restaurant->description = "Description $i";
            $restaurant->image_url = "Url $i";

            $repo->create($restaurant);
        }

        // When we call index() on our controller
        $controller = new App\Controller\RestaurantsController($repo);
        $response = $controller->index();

        // Then it should show a title
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString("<h1>Restaurants</h1>", $response->getContent());

        // And it should show 3 restaurants
        for ($i = 0; $i < 3; $i++) {
            $this->assertStringContainsString("Title $i", $response->getContent());
        }
    }
}
