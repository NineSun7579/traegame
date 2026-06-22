<?php
/**
 * 认证控制器
 */

require_once APP_ROOT . '/app/core/Controller.php';

class AuthController extends Controller {
    
    /**
     * 显示登录页面
     */
    public function login() {
        // 如果已登录，跳转到仪表板
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }
        
        // 处理登录表单提交
        if ($this->isPost()) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            
            if (empty($username) || empty($password)) {
                Session::setFlash('error', '请输入用户名和密码');
            } else {
                $result = Auth::login($username, $password);
                
                if ($result['success']) {
                    $this->redirect('/dashboard');
                    return;
                } else {
                    Session::setFlash('error', $result['message']);
                }
            }
        }
        
        // 显示登录页面
        $this->view('auth/login', [
            'pageTitle' => '登录 - ' . APP_NAME,
            'error' => Session::getFlash('error')
        ]);
    }
    
    /**
     * 用户登出
     */
    public function logout() {
        Auth::logout();
        $this->redirect('/login');
    }
}