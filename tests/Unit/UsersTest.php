<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function itCanStoreAUserInTheDatabase()
    {
        // test make() method
        $user = make('App\User');
        $user->save();
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

        //test create() method
        $anotherUser = create('App\User');
        $this->assertDatabaseHas('users', [
            'email' => $anotherUser->email
        ]);

    }

    /**
     * @test
     * @return void
     */
    public function aUserCanCreateAnAccount()
    {
        $email = 'obura@domain.com';
        $this->post('/register', [
            'first_name' => 'Sammy',
            'last_name' => 'Tongoi',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }
    
}
