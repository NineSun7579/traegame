<?php
/**
 * 首页控制器
 */

require_once APP_ROOT . '/app/core/Controller.php';

class HomeController extends Controller {
    
    public function index() {
        // 检查用户是否已登录
        if (Auth::check()) {
            // 已登录，跳转到仪表板
            $this->redirect('/dashboard');
        } else {
            // 未登录，跳转到登录页
            $this->redirect('/login');
        }
    }
}