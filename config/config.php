<?php

return [
    'name'       => 'Category',

    'middleware' => [
        'allow_middleware'      => true,
        'list_of_middlewares'   => [
            //list all allowed middleware that register in main project middleware (bootstrap/app.php)
            // 'checkMiddlewareApply',
            // new Middleware('log', only: ['index']),
            // new Middleware('subscribed', except: ['store']),
        ],
    ]
];