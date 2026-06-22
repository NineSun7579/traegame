<?php
/**
 * 视图类
 * 处理视图渲染
 */

class View {
    private $data = [];
    private $viewPath;
    
    public function __construct() {
        $this->viewPath = APP_ROOT . '/app/views/';
    }
    
    /**
     * 设置视图数据
     */
    public function set($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }
    
    /**
     * 批量设置视图数据
     */
    public function setData($data) {
        $this->data = array_merge($this->data, $data);
        return $this;
    }
    
    /**
     * 渲染视图
     */
    public function render($viewName, $data = []) {
        // 合并数据
        $data = array_merge($this->data, $data);
        
        // 提取数据变量
        extract($data);
        
        // 视图文件路径
        $viewFile = $this->viewPath . $viewName . '.php';
        
        // 检查视图文件是否存在
        if (!file_exists($viewFile)) {
            if (APP_DEBUG) {
                die("视图文件不存在: {$viewName}");
            } else {
                die("页面加载失败");
            }
        }
        
        // 开启输出缓冲
        ob_start();
        
        // 加载视图文件
        include $viewFile;
        
        // 获取缓冲内容
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * 渲染视图并输出
     */
    public function display($viewName, $data = []) {
        echo $this->render($viewName, $data);
    }
    
    /**
     * 渲染带有布局的视图
     */
    public function renderWithLayout($viewName, $layoutName = 'main', $data = []) {
        // 渲染视图内容
        $content = $this->render($viewName, $data);
        
        // 将内容传递给布局
        $data['content'] = $content;
        
        // 渲染布局
        return $this->render('layouts/' . $layoutName, $data);
    }
    
    /**
     * 渲染带有布局的视图并输出
     */
    public function displayWithLayout($viewName, $layoutName = 'main', $data = []) {
        echo $this->renderWithLayout($viewName, $layoutName, $data);
    }
    
    /**
     * 包含部分视图
     */
    public function partial($partialName, $data = []) {
        // 合并数据
        $data = array_merge($this->data, $data);
        
        // 提取数据变量
        extract($data);
        
        // 部分视图文件路径
        $partialFile = $this->viewPath . 'partials/' . $partialName . '.php';
        
        // 检查部分视图文件是否存在
        if (!file_exists($partialFile)) {
            if (APP_DEBUG) {
                echo "<!-- 部分视图不存在: {$partialName} -->";
            }
            return;
        }
        
        // 加载部分视图文件
        include $partialFile;
    }
    
    /**
     * 渲染JSON响应
     */
    public function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 重定向
     */
    public function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}