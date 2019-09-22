<?php

namespace App\Http\Controllers;

use App\Repositories\Stories;
use App\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $stories; 

    public function __construct(Stories $stories)
    {
        $this->authorizeResource(Story::class, 'story');
        $this->stories = $stories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stories = $this->stories->published($request->query('page', 1));

        return view('stories.index')->withStories($stories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        return view('stories.show')->withStory($story);
    }
}
