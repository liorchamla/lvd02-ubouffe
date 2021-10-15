<?php

namespace App\Repository;

use App\Dto\Restaurant;
use PDO;

class RestaurantRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        return $this->pdo->query("SELECT * FROM restaurant")
            ->fetchAll(PDO::FETCH_CLASS, Restaurant::class);
    }

    public function create(Restaurant $restaurant)
    {
        $query = $this->pdo->prepare('
            INSERT INTO restaurant SET 
            title = :title,
            description = :description,
            image_url = :image_url
        ');

        $query->execute([
            'title' => $restaurant->title,
            'description' => $restaurant->description,
            'image_url' => $restaurant->image_url
        ]);
    }
}
