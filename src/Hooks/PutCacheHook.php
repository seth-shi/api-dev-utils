<?php


namespace SethShi\ApiDevUtils\Hooks;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PutCacheHook
{
    public function cacheAble(
        Request $request,
        Response $response
    )
    {
        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
