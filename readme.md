## API 开发工具包
* cache response
* response helper

# Cache Response Middleware
* 对`API`进行缓存,并且只支持`redis`,因为需要使用`cache tag`功能
* 如果不使用`tag`功能,如果某个路由的缓存根据不同的`query`参数有多个缓存,当清除的时候无法处理
* 当想要删除某个路由所有的缓存可直接使用`Cache::tag($uri)->clear()`
