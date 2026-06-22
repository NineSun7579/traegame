<?php
/**
 * 控制器基类
 * 所有控制器都继承此类
 */

class Controller {
    
    /**
     * 加载视图
     */
    protected function view($viewName, $data = []) {
        // 提取数据变量
        extract($data);
        
        // 视图文件路径
        $viewFile = APP_ROOT . '/app/views/' . $viewName . '.php';
        
        // 检查视图文件是否存在
        if (!file_exists($viewFile)) {
            if (APP_DEBUG) {
                die("视图文件不存在: {$viewName}");
            } else {
                die("页面加载失败");
            }
        }
        
        // 加载视图文件
        require_once $viewFile;
    }
    
    /**
     * 加载布局模板
     */
    protected function layout($layoutName, $data = []) {
        // 提取数据变量
        extract($data);
        
        // 布局文件路径
        $layoutFile = APP_ROOT . '/app/views/layouts/' . $layoutName . '.php';
        
        // 检查布局文件是否存在
        if (!file_exists($layoutFile)) {
            if (APP_DEBUG) {
                die("布局文件不存在: {$layoutName}");
            } else {
                die("页面加载失败");
            }
        }
        
        // 加载布局文件
        require_once $layoutFile;
    }
    
    /**
     * 获取POST数据
     */
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
    
    /**
     * 获取GET数据
     */
    protected function getGet($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
    
    /**
     * 获取请求数据
     */
    protected function getRequest($key = null, $default = null) {
        if ($key === null) {
            return $_REQUEST;
        }
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }
    
    /**
     * JSON响应
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * 重定向
     */
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * 检查是否为POST请求
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * 检查是否为GET请求
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * 检查是否为AJAX请求
     */
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * 生成CSRF令牌
     */
    protected function generateCsrfToken() {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }
    
    /**
     * 验证CSRF令牌
     */
    protected function verifyCsrfToken($token) {
        return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }
    
    /**
     * 获取CSRF令牌隐藏字段
     */
    protected function csrfField() {
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $this->generateCsrfToken() . '">';
    }
}