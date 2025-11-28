<?php
session_name('sysmax-tuya');
session_start();
declare(strict_type=1);
require __DIR__."/routes/Router.php";

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (strpos($path, '/public/') !== false) {
    $staticFile = __DIR__ . $path;

    if (is_file($staticFile)) {
        return false;
    }
}

$publicRoutes = ['/login'];
if (!in_array($path, $publicRoutes) && !isset($_SESSION['userName'])) {
    header("Location: /login");
    exit;
}

$router = new Router();

$router->add('/', function(){
    include_once __DIR__ . '/src/index.php';
});

$router->add('/login', function (){
    include_once __DIR__ . '/src/login.php';
});

$router->add('/settings', function (){
    include_once __DIR__ . '/src/pages/userSettings.php';
});

$router->add('/rates', function (){
    include_once __DIR__ . '/src/pages/rates.php';
});

$router->add('/reports', function (){
    include_once __DIR__ . '/src/pages/admonReports.php';
});

$router->dispatch($path);
