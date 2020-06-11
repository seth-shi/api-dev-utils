## API 开发工具包

# Install
```bash
# 安装依赖
composer require seth-shi/api-dev-utils
# 发布资源包 (按需配置 config/utils.php)
php artisan vendor:publish --tag=config  --force
```

## CacheResponseMiddleware
* 可在`app/Http/Kernel::$middlewareGroups`的`api`数组中加入`\SethShi\ApiDevUtils\Middleware\CacheResponseMiddleware::class`
* 也可自定义到`$routeMiddleware`或者继承`\SethShi\ApiDevUtils\Middleware\CacheResponseMiddleware::class`此类使用
* 对`API`进行缓存,并且只支持`redis`,因为需要使用`cache tag`功能(如果不使用`tag`功能,如果某个路由的缓存根据不同的`query`参数有多个缓存,当清除的时候无法处理)
* 当想要删除某个路由所有的缓存可直接使用`Cache::tag($uri)->clear()`


## ResponseUtil
* 封装好统一的后端响应格式(配合上`Laravel`的`ApiResource`使用)
```bash
<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use SethShi\ApiDevUtils\Utils\ResponseUtil;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->get();
        
        $resources = UserResource::collection($users);
        
        return ResponseUtil::responseJsonData($resources);
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (! $request->has('foo')) {
            
            return ResponseUtil::responseJsonAsBadRequest('no foo');
        }
        
        $user = null;
        if (is_null($user)) {
            
            return ResponseUtil::responseJsonAsNotFound();
        }
        
        try {
            
            // bar
            throw new \Exception('bar');
            
        } catch (\Exception $e) {
            
            return ResponseUtil::responseJsonAsServerError($e->getMessage());
        }
        
        
        return ResponseUtil::responseJsonMsg('success');
    }
}
```
