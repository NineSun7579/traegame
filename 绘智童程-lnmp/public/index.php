<?php
/**
 * 绘智童程 - LNMP项目入口文件
 * 基于STM32H7的无屏编程启蒙系统管理后台
 */

// 定义应用根目录
define('APP_ROOT', dirname(__DIR__));

// 加载配置文件
require_once APP_ROOT . '/app/config/config.php';

// 加载核心类
require_once APP_ROOT . '/app/core/Database.php';
require_once APP_ROOT . '/app/core/Router.php';
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Model.php';
require_once APP_ROOT . '/app/core/View.php';
require_once APP_ROOT . '/app/core/Session.php';
require_once APP_ROOT . '/app/core/Auth.php';

// 启动会话
Session::start();

// 设置时区
date_default_timezone_set(APP_TIMEZONE);

// 错误报告
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// 初始化数据库连接
Database::getInstance();

// 初始化路由器
$router = new Router();

// 定义路由规则
$router->addRoute('', 'HomeController@index');
$router->addRoute('login', 'AuthController@login');
$router->addRoute('logout', 'AuthController@logout');
$router->addRoute('dashboard', 'DashboardController@index');
$router->addRoute('courses', 'CourseController@index');
$router->addRoute('courses/create', 'CourseController@create');
$router->addRoute('courses/edit/(\d+)', 'CourseController@edit');
$router->addRoute('courses/delete/(\d+)', 'CourseController@delete');
$router->addRoute('students', 'StudentController@index');
$router->addRoute('students/create', 'StudentController@create');
$router->addRoute('students/edit/(\d+)', 'StudentController@edit');
$router->addRoute('students/delete/(\d+)', 'StudentController@delete');
$router->addRoute('devices', 'DeviceController@index');
$router->addRoute('lessons', 'LessonController@index');
$router->addRoute('resources', 'ResourceController@index');
$router->addRoute('cards', 'CardController@index');
$router->addRoute('analytics', 'AnalyticsController@index');
$router->addRoute('settings', 'SettingsController@index');

// API路由
$router->addRoute('api/courses', 'ApiCourseController@index');
$router->addRoute('api/courses/(\d+)', 'ApiCourseController@show');
$router->addRoute('api/students', 'ApiStudentController@index');
$router->addRoute('api/students/(\d+)', 'ApiStudentController@show');
$router->addRoute('api/devices', 'ApiController@devices');
$router->addRoute('api/stats', 'ApiController@stats');

// 处理请求
$router->dispatch($_SERVER['REQUEST_URI']);