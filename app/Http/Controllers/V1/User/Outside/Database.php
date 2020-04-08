<?php


namespace App\Http\Controllers\V1\User\Outside;


use http\Env\Request;
use Illuminate\Support\Facades\DB;

class Database
{

    public function base(){
        // 获取pdo基础实例
        $pdo = DB::connection()->getPdo();
    }

    // 查询
    public function users() {
        $users = DB::select('SELECT * FROM `user` WHERE (`id` > ?) LIMIT 0,100',[0]);
//        foreach ($users as $k => $v) {
//            var_dump($v->name);
//        }
        return response()->json($users);
    }

    // 插入
    public function add(Request $request) {
        $adds = $request->post();
        $affected = DB::insert('INSERT INTO `user` ( `name`, `time` ) VALUES ( ?, ? )',['Bob',time()]);
        return response()->json($affected);
    }

    // 删除
    public function del(Request $request) {
        $affected = DB::delete('DELETE FROM `user` WHERE ( `id` = ? )',[-1]);
        return response()->json($affected);
    }

    // 更新
    public function ups(Request $request) {
        $affected = DB::delete('UPDATE `user` SET `time` = ?, `status` = ? WHERE ( `id` = ? )',[time(),-1,1]);
        return response()->json($affected);
    }

    // 直接执行sql
    public function exec(Request $request) {
        DB::statement('DROP TABLE `user`');
        return response()->json();
    }

    // 事务
    public function transaction(Request $request) {
        $result = false;
        // 第二个参数, 定义发生死锁是应重新尝试执行事务的次数
        DB::transaction(function () use ($request) {
            DB::table('user')->update(['votes' => 1]);
            DB::table('post')->delete();
        }, 5);

        // 手动事务
        DB::beginTransaction();
        DB::rollBack();
        DB::commit();
    }

    // 查询器
    public function select(Request $request) {
        // 查询多条
        $users = DB::table('user')->get();
        foreach ($users as $user) {
            echo $user->name;
        }
        // 查询指定条件的第一条
        $user = DB::table('user')->where('name', 'John')->first();
        echo $user->name;
        // 查询某列的单个值
        $email = DB::table('user')->where('name', 'John')->value('email');
        // 按照id检索
        $user = DB::table('user')->find(3);
        // 检索单列的所有值
        $usernames = DB::table('user')->pluck('username');
        foreach ($usernames as $username) {
            echo $username;
        }
        // 自定义列
        $roles = DB::table('user')->pluck('title', 'name');
        foreach ($roles as $name => $title) {
            echo $title;
        }
        // 聚合函数
        $users = DB::table('user')->count();
        $price = DB::table('order')->max('price');
        $price = DB::table('order')->where('finalized', 1)->avg('price');
        DB::table('order')->where('finalized', 1)->exists();
        DB::table('order')->where('finalized', 1)->doesntExist();
    }
}
