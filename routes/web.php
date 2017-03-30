<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('topics', 'TopicController@topics');
$app->get('topic/add', 'TopicController@addTopic');
$app->post('topic/add', 'TopicController@doAddTopic');
//$app->post('topic/upvote', 'TopicController@upvote');
$app->get('topic/upvote/{id}', 'TopicController@upvote');


$app->get('topics/purge', 'TopicController@purge');