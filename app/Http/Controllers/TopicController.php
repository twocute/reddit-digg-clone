<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Loads the view that allows the user to add a topic
     *
     * @return void
     */
    public function addTopic()
    {
        return view('topic.add');
    }

    /**
     * Actually adds the topic to Redis
     *
     * @param Request  The Request object
     *
     * @return void
     */
    public function doAddTopic(Request $request)
    {
        //dd($request->all());

        // Validation, because we don't want blanks or longer than 255 chars
        $this->validate($request, ['topic' => 'required|max:255']);

        return "passed";
    }

    /**
     * Loads the view that shows all the topics
     *
     * @return void
     */
    public function topics()
    {
        return view('topic.list');
    }
}
