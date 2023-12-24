<?php

namespace Tests\Feature;

use Tests\TestCase;

class RandomDataControllerTest extends TestCase
{
    /**
     * Testa se a rota de index retorna um status HTTP 200.
     *
     * @return void
     */
    public function testIndexRouteReturnsOk()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
