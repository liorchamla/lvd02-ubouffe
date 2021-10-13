<?php

use App\Controller\HelloController;
use App\Http\Request;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase {
    
    public function test_it_displays_name_from_get() {
        // Setup
        // http://localhost?name=Lior
        $request = new Request([
            'name' => 'Lior'
        ]);

        // Action
        $controller = new HelloController;
        $response = $controller->hello($request);

        // Resultat (tests)
        $this->assertEquals("Hello Lior", $response->getContent()); // Contenu
        $this->assertEquals(200, $response->getStatusCode()); // Status
        $this->assertEquals("text/html; charset=utf-8", $response->getHeader('Content-Type')); // Headers
    }

    public function test_it_displays_hello_world() {
        // Setup
        // Action
        $controller = new HelloController;
        $response = $controller->hello(new Request());

        // Resultat (tests)
        $this->assertEquals("Hello World", $response->getContent()); // Contenu
        $this->assertEquals(200, $response->getStatusCode()); // Status
        $this->assertEquals("text/html; charset=utf-8", $response->getHeader('Content-Type'));
        // Headers
    }
}