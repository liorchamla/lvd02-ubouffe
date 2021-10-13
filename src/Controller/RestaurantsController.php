<?php

namespace App\Controller;

use App\Http\Response;

class RestaurantsController {
    public function index() {
        return new Response(200, "<h1>Restaurants</h1>");
    }
}