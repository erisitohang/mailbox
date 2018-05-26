<?php

$router->group([
    'prefix' => 'api/v1',
    'namespace' => 'Api\V1',
    'middleware' => 'BasicAuth'
], function () use ($router) {
    $router->get('message', [
        'as' => 'message.index',
        'uses' => 'MessageController@index',
    ]);

    $router->get('message/archived', [
        'as' => 'message.archived',
        'uses' => 'MessageController@archived',
    ]);

    $router->get('message/{id}', [
        'as' => 'message.show',
        'uses' => 'MessageController@show',
    ]);

    $router->put('message/read', [
        'as' => 'message.read',
        'uses' => 'MessageController@read',
    ]);

    $router->put('message/archive', [
        'as' => 'message.archive',
        'uses' => 'MessageController@archive',
    ]);
});