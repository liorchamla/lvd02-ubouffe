<?php

use App\Dto\Restaurant;
use App\Repository\RestaurantRepository;
use PHPUnit\Framework\TestCase;

class RestaurantRepositoryTest extends TestCase
{
    public function test_it_can_insert_a_new_restaurant()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=ubouffe_test", "root", "root");
        $pdo->query('DELETE FROM restaurant');

        // instancier un RestaurantRepository
        $repo = new App\Repository\RestaurantRepository($pdo);

        // appeler la méthode create() avec des données précises
        $restaurant = new App\Dto\Restaurant;
        $restaurant->title = "MOCK_TITLE";
        $restaurant->description = "MOCK_DESCRIPTION";
        $restaurant->image_url = "MOCK_URL";

        $repo->create($restaurant);

        // requête SELECT après coup, puis vérification des données reçues après requête
        $results = $pdo->query('SELECT * FROM restaurant');
        $this->assertEquals(1, $results->rowCount());

        /** @var App\Dto\Restaurant */
        $data = $results->fetch(PDO::FETCH_OBJ);
        $this->assertEquals("MOCK_TITLE", $data->title);
        $this->assertEquals("MOCK_DESCRIPTION", $data->description);
        $this->assertEquals("MOCK_URL", $data->image_url);
    }

    public function test_it_can_find_all_restaurants()
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

        // When I call findAll() on my Repository (Quand j'appelle findAll() sur mon Repo)
        $restaurants = $repo->findAll();

        // Then it should return 3 restaurants
        $this->assertCount(3, $restaurants);
    }
}
