<?php

namespace SethShi\ApiDevUtils\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class CacheResponseMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cacheConfig = Config::get('utils.api_cache', []);
    
        if (! $cacheConfig['enable']) {
            return $next($request);
        }
    
        // only cache http get request
        if (! $request->isMethod('GET')) {
            return $next($request);
        }
        
        
        $uri = $request->route()->getUri();
        if (! isset($cacheConfig['routes'][$uri])) {
            
            return $next($request);
        }
        
        $routeConfig = $cacheConfig['routes'][$uri];
        $parameters = $this->assemble($routeConfig[0] ?? [], $request->all());
        $headers = $this->assemble($routeConfig[1] ?? [], $request->headers->all());
        $ttl = $routeConfig[2] ?? $cacheConfig['global_ttl'];
        
        $cacheKey = http_build_query(array_merge($parameters, $headers));
        // cache options
        $cacheStore = Cache::tags($uri);
        
        $cacheResponse = $cacheStore->get($cacheKey);
        if (is_null($cacheResponse)) {
            
            $cacheResponse = $next($request);
            $cacheStore->put($cacheKey, $cacheResponse, $ttl);
        }

        return $cacheResponse;
    }
    
    protected function assemble(array $fields, array $data)
    {
        if (empty($fields) || empty($data)) {
            return [];
        }
    
        return Arr::sortRecursive(Arr::only($data, $fields));
    }
}
