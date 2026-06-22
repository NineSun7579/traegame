<?php
/**
 * 会话管理类
 */

class Session {
    
    /**
     * 启动会话
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            // 设置会话配置
            session_name(SESSION_NAME);
            session_set_cookie_params([
                'lifetime' => SESSION_LIFETIME,
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            
            session_start();
        }
    }
    
    /**
     * 设置会话变量
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    /**
     * 获取会话变量
     */
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * 检查会话变量是否存在
     */
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    /**
     * 删除会话变量
     */
    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * 清除所有会话变量
     */
    public static function clear() {
        session_unset();
    }
    
    /**
     * 销毁会话
     */
    public static function destroy() {
        session_destroy();
        $_SESSION = [];
    }
    
    /**
     * 重新生成会话ID
     */
    public static function regenerate() {
        session_regenerate_id(true);
    }
    
    /**
     * 获取会话ID
     */
    public static function getId() {
        return session_id();
    }
    
    /**
     * 设置Flash消息
     */
    public static function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }
    
    /**
     * 获取Flash消息
     */
    public static function getFlash($key, $default = null) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return $default;
    }
    
    /**
     * 检查Flash消息是否存在
     */
    public static function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }
    
    /**
     * 设置用户登录信息
     */
    public static function login($userId, $userData = []) {
        self::set('user_id', $userId);
        self::set('user_data', $userData);
        self::set('logged_in', true);
        self::set('login_time', time());
        self::regenerate();
    }
    
    /**
     * 用户登出
     */
    public static function logout() {
        self::clear();
        self::destroy();
    }
    
    /**
     * 检查用户是否已登录
     */
    public static function isLoggedIn() {
        return self::get('logged_in', false);
    }
    
    /**
     * 获取当前用户ID
     */
    public static function getUserId() {
        return self::get('user_id');
    }
    
    /**
     * 获取当前用户数据
     */
    public static function getUserData() {
        return self::get('user_data', []);
    }
    
    /**
     * 检查会话是否过期
     */
    public static function isExpired() {
        $loginTime = self::get('login_time', 0);
        return (time() - $loginTime) > SESSION_LIFETIME;
    }
}