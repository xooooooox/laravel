<?php

namespace App\Http\Middleware;

use Closure;

class V1Token
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
        $user_id = 1;
        // 在url中间添加query参数
        $request->attributes->add(['user_id'=>$user_id]); // $request->get('user_id');
        // 在请求体中,添加参数
        $request->merge(['user_id'=>$user_id]); // $request->input('user_id'); // $request->post('user_id');
        return $next($request);
    }
}
