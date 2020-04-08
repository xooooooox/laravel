<?php

namespace App\Http\Middleware;

use Closure;

class V1Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = $request->header('user_id',0);
        if ($user_id == 0) {
            // 返回未登录的请求信息
            return response()->json(['err'=>-1,'msg'=>'please login first']);
        }
        // 已经登录, 继续下一个handle
        return $next($request);
    }
}
