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
    public function it_appends_model_and_path_to_a_collection_of_models()
    {
        create('App\User', [], 2);

        $users = \App\User::all();

        $users->each(function($user){
            $this->assertArrayHasKey('model', $user);
            $this->assertArrayHasKey('path', $user);
        });
    }

    /**
     * @test
     * @return void
     */
    public function it_appends_model_and_path_to_a_model()
    {
        $user = create('App\User');
        $this->assertArrayHasKey('model', $user);
        $this->assertArrayHasKey('path', $user);
    }
}
