<?php
/**
 * 路由器类
 * 处理URL路由和请求分发
 */

class Router {
    private $routes = [];
    
    /**
     * 添加路由规则
     */
    public function addRoute($pattern, $handler) {
        // 将路由模式转换为正则表达式
        $regex = preg_replace('/\//', '\\/', $pattern);
        $regex = '/^' . $regex . '$/';
        
        $this->routes[] = [
            'pattern' => $regex,
            'handler' => $handler
        ];
    }
    
    /**
     * 分发请求
     */
    public function dispatch($uri) {
        // 清理URI
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        // 如果URI为空，设置为首页
        if (empty($uri)) {
            $uri = '';
        }
        
        // 尝试匹配路由
        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                // 提取控制器和方法
                list($controllerName, $methodName) = explode('@', $route['handler']);
                
                // 提取参数（排除第一个匹配项，即完整匹配）
                $params = array_slice($matches, 1);
                
                // 加载控制器并调用方法
                $this->callController($controllerName, $methodName, $params);
                return;
            }
        }
        
        // 404页面
        $this->show404();
    }
    
    /**
     * 调用控制器方法
     */
    private function callController($controllerName, $methodName, $params = []) {
        // 控制器文件路径
        $controllerFile = APP_ROOT . '/app/controllers/' . $controllerName . '.php';
        
        // 检查控制器文件是否存在
        if (!file_exists($controllerFile)) {
            $this->show404();
            return;
        }
        
        // 加载控制器文件
        require_once $controllerFile;
        
        // 检查控制器类是否存在
        if (!class_exists($controllerName)) {
            $this->show404();
            return;
        }
        
        // 创建控制器实例
        $controller = new $controllerName();
        
        // 检查方法是否存在
        if (!method_exists($controller, $methodName)) {
            $this->show404();
            return;
        }
        
        // 调用控制器方法
        call_user_func_array([$controller, $methodName], $params);
    }
    
    /**
     * 显示404页面
     */
    private function show404() {
        http_response_code(404);
        
        // 尝试加载404视图
        $viewFile = APP_ROOT . '/app/views/errors/404.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo '<!DOCTYPE html>
            <html lang="zh-CN">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>404 - 页面未找到</title>
                <style>
                    body { font-family: "Noto Sans SC", sans-serif; background: #0a0e1a; color: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
                    .container { text-align: center; padding: 40px; }
                    h1 { font-size: 6rem; margin: 0; background: linear-gradient(135deg, #ff6b6b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
                    p { font-size: 1.2rem; color: #94a3b8; margin: 20px 0; }
                    a { color: #38bdf8; text-decoration: none; }
                    a:hover { text-decoration: underline; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>404</h1>
                    <p>抱歉，您访问的页面不存在。</p>
                    <p><a href="/">返回首页</a></p>
                </div>
            </body>
            </html>';
        }
        exit;
    }
}