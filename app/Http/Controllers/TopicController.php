<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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

        //return "passed";

        // Insert the topic into Redis sorted set (duplicates allowed)
        // In this case, I don't check for duplicates, because I use an autoincrement ID for index
        $object = ['topic' => $request->input('topic'), 'upvotes' => 0, 'downvotes' => 0];
        $global_next_id = Redis::incr('global_id');
        //Redis::set($global_next_id, json_encode($object));
        Redis::hmset($global_next_id, $object);

        // Also updates the upvotes sorted set secondary index
        Redis::zadd('upvote_index', 0, $global_next_id);
        Redis::zadd('downvote_index', 0, $global_next_id);

        return "success";
    }

    /**
     * Add an upvote to a topic and also updates its index
     *
     * @param id  The id of the topic receiving the upvote
     *
     * @return string  "success" on success, "failure" on failure
     */
    public function upvote($id)
    {
        // First check if the object exists before trying to upvote it
        $object = Redis::hgetall($id);

        if (!empty($object)) {
            // Update the topic object
            Redis::hincrby($id, 'upvotes', 1);

            // Update the index
            Redis::zincrby('upvote_index', 1, $id);

            return "success";
        }

        return "failure";
    }

    /**
     * Loads the view that shows all the topics
     *
     * @return void
     */
    public function topics()
    {
        //$global_next_id = Redis::incr('global_id');
        //dd($global_next_id);
        //dd(Redis::get(1))
        //dd(Redis::hgetall(1));
        dd(Redis::zrevrange('upvote_index', 0, -1));
        //dd(Redis::zrevrange('downvote_index', 0, -1));
        return view('topic.list');
    }
}
