<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppendsModelandPathTraitTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itAppendsModelAndPathToModelsWithMatchingTrait()
    {
        create('App\User');

        $user = \App\User::first();

        $this->assertArrayHasKey('model', $user->toArray());
        $this->assertArrayHasKey('path', $user->toArray());
    }
}
