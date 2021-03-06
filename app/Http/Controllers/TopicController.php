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
     * Actually adds the topic to Redis
     *
     * @param Request  The Request object
     *
     * @return redirect  Back to itself so you can quickly add another topic
     */
    public function doAddTopic(Request $request)
    {
        // Validation, because we don't want blanks or longer than 255 chars
        $this->validate($request, ['topic' => 'required|max:255']);

        // Insert the topic into Redis sorted set (duplicates allowed)
        // In this case, I don't check for duplicates, because I use an autoincrement ID for index
        $object = ['topic' => $request->input('topic'), 'upvotes' => 0, 'downvotes' => 0];
        $global_next_id = Redis::incr('global_id');
        Redis::hmset($global_next_id, $object);

        // Also updates the upvotes sorted set secondary index
        Redis::zadd('upvote_index', 0, $global_next_id);

        // Not required
        //Redis::zadd('downvote_index', 0, $global_next_id);

        return redirect('topics');
    }

    /**
     * Add an downvote to a topic and also updates its index
     *
     * @param id  The id of the topic receiving the downvote
     *
     * @return mixed  Redirects to topics page on success, "failure" on failure
     */
    public function downvote($id)
    {
        // First check if the object exists before trying to upvote it
        $object = Redis::hgetall($id);

        if (!empty($object)) {
            // Update the topic object
            Redis::hincrby($id, 'downvotes', 1);

            // Update the index in the Redis sorted set
            //Redis::zincrby('downvote_index', 1, $id);

            return redirect('topics');
        }

        return "failure";
    }

    /**
     * Add an upvote to a topic and also updates its index
     *
     * @param id  The id of the topic receiving the upvote
     *
     * @return mixed  Redirects to topics page on success, "failure" on failure
     */
    public function upvote($id)
    {
        // First check if the object exists before trying to upvote it
        $object = Redis::hgetall($id);

        if (!empty($object)) {
            // Update the topic object
            Redis::hincrby($id, 'upvotes', 1);

            // Update the index in the Redis sorted set
            Redis::zincrby('upvote_index', 1, $id);

            return redirect('topics');
        }

        return "failure";
    }

    /**
     * Remove all topics from Redis. "This command never fails."
     *
     * @return redirect  Redirects back to topics page
     */
    public function purge()
    {
        Redis::flushall();

        return redirect('topics');
    }

    /**
     * Loads the homepage that shows top 20 topics organized by upvotes
     *
     * @return void
     */
    public function homepage()
    {
        $topics_index = Redis::zrevrange('upvote_index', 0, 19);

        return view('topic.list', ['topics' => $this->buildObjectsFromList($topics_index)]);
    }

    /**
     * Loads the view that shows all the topics
     *
     * @return void
     */
    public function topics()
    {
        $topics_index = Redis::zrevrange('upvote_index', 0, -1);

        return view('topic.list', ['topics' => $this->buildObjectsFromList($topics_index)]);
    }

    /******************************************************
     * HELPER FUNCTIONS
     *****************************************************/

    /**
     * Fetch the objects identified by the list of ids from Redis
     *
     * @param array  List of the ids we need to fetch from Redis
     *
     * @return array  Array of objects that is stored in Redis
     */
    public function buildObjectsFromList(array $list_of_ids)
    {
        $objects = array();

        foreach($list_of_ids as $id) {
            $object = Redis::hgetall($id);

            // Pass the ID in the object too
            $object['id'] = $id;
            $objects[] = $object;
        }

        return $objects;
    }
}
