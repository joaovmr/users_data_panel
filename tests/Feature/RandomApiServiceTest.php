<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RandomApiService;

// Este teste verifica se getUsers retorna dados não vazios.
class RandomApiServiceTest extends TestCase
{
    public function testGetUsersReturnsData()
    {
        $randomApiService = new RandomApiService();
        $users = $randomApiService->getUsers();

        $this->assertNotEmpty($users);
    }
}
