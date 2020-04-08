<?php


namespace App\Http\Controllers\V1\User\Outside;


use Illuminate\Http\Request;

class IndexController
{

    public function register(Request $request) {
        return response()->json($request->post());
    }

    public function login(Request $request) {
        var_dump('控制器方法输出login');
    }

}
