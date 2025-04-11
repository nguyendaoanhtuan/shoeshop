<?php
session_start();
define('BASE_URL', '/shoeshop/');

require_once 'app/config/database.php';
require_once 'app/core/Auth.php';
require_once 'app/core/Router.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

$requestUri = str_replace(BASE_URL, '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new Router($db);
$router->dispatch($requestUri, $requestMethod);