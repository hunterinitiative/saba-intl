<?php

namespace Tests\Feature;

use Illuminate\Auth\Access\AuthorizationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoriesTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->authenticateAsAdmin();
    }

    /**
     * @test
     * @return void
     */
    public function an_admin_can_create_an_story()
    {
        $story = create('App\Story');

        $this->assertDatabaseHas('stories', [
            'id' => $story->id,
            'title' => $story->title,
            'content' => $story->content,
            'cover' => $story->cover,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function a_non_admin_cannot_create_an_story()
    {
        $user = create('App\User'); // Authenticate as a new user (without admin privileges)

        $this->assertFalse($user->can('create', 'App\Story'));
    }

    /**
     * @test
     * @return void
     */
    public function any_user_can_view_an_story()
    {
        // can view indexed stories
        $user = create('App\User'); // Authenticate as a new user (without admin privileges)
        $this->assertTrue($user->can('viewAny', 'App\Story'));

        // can view a specific story
        $story = create('App\Story');
        $this->assertTrue($user->can('view', $story));
    }

    /**
     * @test
     * @return void
     */
    public function the_index_defaults_to_published_stories_only()
    {
        $this->authenticateAsAdmin();

        $stories = create('App\Story', [], 3);

        $firstStory = $stories->first();
        $lastStory = $stories->last();

        $this->get('/stories')
             ->assertSee($firstStory->title) 
             ->assertSee($lastStory->title);

        $firstStory->unpublish();

        $this->get('/stories')
             ->assertDontSee($firstStory->title) 
             ->assertSee($lastStory->title);   
    }
}
