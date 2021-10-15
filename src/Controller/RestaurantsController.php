<?php

namespace App\Controller;

use App\Http\Response;
use App\Repository\RestaurantRepository;

class RestaurantsController
{
    private RestaurantRepository $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function index()
    {
        $restaurants = $this->restaurantRepository->findAll();

        ob_start();
        require_once __DIR__ . '/../../templates/restaurant/index.html.php';
        $html = ob_get_clean();

        return new Response(200, $html);
    }
}
