<?php

// This is the router for
$app->group('/api', function() use ($app, $log) {
    $app->group('/v1', function() use ($app, $log) {
        // users
        $app->group('/users', function() use ($app, $log) {
            $app->get('/', '\API\Core\Controller\Users:select');
            $app->get('/:username', '\API\Core\Controller\Users:getId');
            $app->post('/', '\API\Core\Controller\Users:insert');

        });
        // messages
        $app->group('/messages', function() use ($app, $log) {
            $app->get('/', '\API\Core\Controller\Messages:select');
            $app->post('/', '\API\Core\Controller\Messages:insert');
            $app->get('/:id', '\API\Core\Controller\Messages:getNames');
            $app->get('/:id/to/:tid', '\API\Core\Controller\Messages:getMessageListFromUser');

        });
    });
});
