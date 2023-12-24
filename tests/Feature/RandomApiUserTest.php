<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\RandomUser;

class RandomUserTest extends TestCase
{
    public function testCreateRandomUserInstance()
    {
        $userData = [
            'uid' => 'test-uid',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $randomUser = new RandomUser($userData);

        $this->assertInstanceOf(RandomUser::class, $randomUser);
        $this->assertEquals('John', $randomUser->first_name);
        $this->assertEquals('Doe', $randomUser->last_name);
    }
}
