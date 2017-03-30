<?php

namespace App\Http\Controllers;

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
        return "to add";
    }

    /**
     * Loads the view that shows all the topics
     *
     * @return void
     */
    public function topics()
    {
        return "to list";
    }
}
