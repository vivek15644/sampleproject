<?php

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
ini_set('display_errors', '0');

$loader = new Loader();
$loader->registerDirs([
    __DIR__ . '/models',
    __DIR__ . '/controllers',
    __DIR__
        ]
);

$loader->register();

$di = new FactoryDefault();
// Set up the database service
$di->set(
        "db", function () {
    return new PdoMysql(
            [
        "host" => "localhost",
        "username" => "root",
        "password" => "pass@123",
        "dbname" => "sampleproject",
            ]
    );
}
);

$app = new Micro($di);

$app->get(
        "/api/users", function() {
    
}
);

$app->get(
        "/api/riders", function() {
    $obj = new UserController();
    $res = $obj->getRiders($_GET);
    print_r(stripslashes(json_encode($res)));
}
);

$app->get(
        "/api/summarylist", function() {
    $obj = new UserController();
    $res = $obj->getOrderSummary();
    print_r(stripslashes(json_encode($res)));
}
);

$app->post(
        "/api/users/create", function()use ($app) {
    $obj = new UserController($app->request->getJsonRawBody());
    $res = $obj->createNewUser();
    print_r(stripslashes(json_encode($res)));
}
);
$app->get(
        "/api/users/dudes/{mob:[a-z 1-9]+}", function($mob) {
    $obj = new UserController();
    print_r(json_decode(json_encode($obj->getDudes($mob)), true));
}
);
$app->handle();
