<?php

namespace Tests\Feature;

use App\Exceptions\AdminAlreadyExistsException;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
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

    /**
     * @test
     * @return void
     */
    public function a_non_superAdmin_user_cannot_create_an_admin()
    {
        $user = create('App\User');

        $this->actingAs($user);

        $this->expectException(AuthorizationException::class);
        
        $response = $this->post('/admins', [
            'user_id' => $user->id
        ]);

        $response->assertUnauthorized();
    }

    /**
     * @test
     * @return void
     */
    public function a_superAdmin_can_create_an_admin()
    {
        $this->authenticateAsSuperAdmin();

        $user = create('App\User');
        
        $response = $this->post('/admins', [
            'user_id' => $user->id
        ]);

        $response->assertRedirect('/admins');

        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function an_admin_can_be_created_by_calling_the_make_admin_method_on_the_user_model()
    {
        $this->authenticateAsSuperAdmin();

        $user = create('App\User');
        
        $user->makeAdmin();
        
        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
        ]);
    }
    /**
     * @test
     * @return void
     */
    public function the_make_admin_method_only_works_if_a_superAdmin_is_authenticated()
    {
        $this->signIn();

        $user = create('App\User');

        $this->expectException(AuthorizationException::class);
        
        $user->makeAdmin();
        
        $this->assertDatabaseMissing('admins', [
            'user_id' => $user->id,
        ]);

        $this->authenticateAsSuperAdmin();
        
        $user->makeAdmin();
        
        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function an_admin_cannot_be_created_more_than_once()
    {
        $this->authenticateAsSuperAdmin();
        
        $user = create('App\User');
        
        $user->makeAdmin();

        $this->expectException(AdminAlreadyExistsException::class);

        $user->makeAdmin();
    }

    /**
     * @test
     * @return void
     */
    public function an_admin_can_be_made_a_super_admin_by_calling_the_make_admin_method_but_only_if_is_super_admin_attribute_equals_1()
    {
        $this->authenticateAsSuperAdmin();
        
        $user = create('App\User');
        
        $user->makeAdmin();

        // this fails as user is already admin
        $this->expectException(AdminAlreadyExistsException::class);
        $user->makeAdmin();

        //try again, providing is_super_admin value of 1 to make them a superAdmin
        $user->makeAdmin(1);

        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
            'is_super_admin' => 1
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function a_superAdmin_can_remove_an_admin()
    {
        $this->authenticateAsSuperAdmin();

        $user = create('App\User');
        
        $user->makeAdmin();

        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
        ]);

        $user->removeAdmin();
        
        $this->assertDatabaseMissing('admins', [
            'user_id' => $user->id,
        ]);
    }
}
