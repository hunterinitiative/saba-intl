<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{

    public function authenticateAsSuperAdmin($user = null)
    {
        $user = $user ?? create('App\User');

        $user->admin()->create([
            'is_super_admin' => 1
        ]);

        $this->actingAs($user);
        
        return $this;
    }

    // /**
    //  * A basic feature test example.
    //  * @test
    //  * @return void
    //  */
    // public function a_user_cannot_create_an_admin()
    // {
    //     $user = create('App\User');

    //     $this->actingAs($user);
        
    //     $response = $this->post('/admins', [
    //         'user_id' => $user->id
    //     ]);

    //     $response->assertUnauthorized();
    // }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_superAdmin_can_create_an_admin()
    {
        $user = create('App\User');

        $this->authenticateAsSuperAdmin($user);
        
        $response = $this->post('/admins', [
            'user_id' => $user->id
        ]);

        $response->assertRedirect('/admins');

        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
        ]);
    }
}
