<?php

return [
    
    'api_cache' => [
        'enable' => env('API_CACHE', false),
        // put cache 之前的操作,如需要重写需继承此类
        'put_hook' => \SethShi\ApiDevUtils\Hooks\PutCacheHook::class,
        'global_ttl' => 60 * 60,
        'routes' => [
            
            'api/v1/hello' => [
                // query parameters
                ['name', 'age'],
                
                // header parameters
                ['token'],
                
                // ttl, use `global_ttl` if none exists
                24 * 60 * 60,
            ]
        ]
    ]
];
