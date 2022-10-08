<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

Router::get('/test1', function () {
    return 'This is Test1';
});

Router::addServer('ws', function () {
    Router::get('/ws', 'App\Controller\WebSocketController');
});

Router::get('/db/add', function(){
    $data = [
        [
            'name'=>'Peter',
            'sex' => 1,
        ],
        [
            'name'=>'Tom',
            'sex' => 1,
        ],
        [
            'name'=>'Susan',
            'sex' => 2,
        ],
        [
            'name'=>'Mary',
            'sex' => 2,
        ],
        [
            'name'=>'Jim',
            'sex' => 1,
        ],
    ];
    foreach ($data as $v) {
        $insertId[] = \Hyperf\DbConnection\Db::table('db_test')->insertGetId($v);
    }
    return $insertId;
});

Router::get('/db/update', function(\Hyperf\HttpServer\Contract\RequestInterface $request){
    $data = [
        'name' => $request->input('name', ''),
        'sex' => $request->input('sex', 0),
        'id' => $request->input("id", 0),
    ];

    if($data['id'] < 1 || !$data['name'] || !in_array($data['sex'], [1, 2])){
        return '参数错误';
    }

    return \Hyperf\DbConnection\Db::table('db_test')->where("id", "=", $data['id'])->update($data);
});

Router::get('/db/delete', function(\Hyperf\HttpServer\Contract\RequestInterface $request){
    $id = $request->input('id', 0);
    if($id < 1){
        return '参数错误';
    }

    return \Hyperf\DbConnection\Db::table('db_test')->delete($id);
});

Router::get('/db/list', function (\Hyperf\HttpServer\Contract\RequestInterface $request) {
    $where = [];
    if($request->has("name")){
        $where[] = ['name', 'like', '%' . $request->input('name') . '%'];
    }
    if($request->has("sex")){
        $where[] = ['sex', '=', $request->input('sex')];
    }

    return \Hyperf\DbConnection\Db::table('db_test')
        ->select(['*'])
        ->where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()
        ->toArray();
});

Router::get('/db/info', function (\Hyperf\HttpServer\Contract\RequestInterface $request, \Hyperf\HttpServer\Contract\ResponseInterface $response) {
    $id = (int)$request->input('id', 0);
    if($id < 1){
        return '参数错误';
    }

    return $response->json(\Hyperf\DbConnection\Db::table('db_test')->find($id));
});

Router::get('/db/model/list', function (\Hyperf\HttpServer\Contract\RequestInterface $request) {
    $where = [];
    if($request->has("name")){
        $where[] = ['name', 'like', '%' . $request->input('name') . '%'];
    }
    if($request->has("sex")){
        $where[] = ['sex', '=', $request->input('sex')];
    }

    return \App\Model\DbTest::select()->where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()
        ->toArray();
});


Router::get('/db/redis/set', function () {
    $redis = Hyperf\Utils\ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
    return $redis->set("time", "看看现在时间 " . date("Y-m-d H:i:s"));
});

Router::get('/db/redis/get', function () {
    $container = Hyperf\Utils\ApplicationContext::getContainer();

    $redis = $container->get(\Hyperf\Redis\Redis::class);

    return $redis->get("time");
});






