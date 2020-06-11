<?php

return [
    
    'api_cache' => [
        'enable' => env('API_CACHE'),
        'global_ttl' => 60 * 60,
        'routes' => [
            
            'hello' => [
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
