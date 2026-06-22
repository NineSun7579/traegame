<?php
/**
 * 认证类
 * 处理用户认证和授权
 */

class Auth {
    
    /**
     * 用户登录
     */
    public static function login($username, $password) {
        $db = Database::getInstance();
        
        // 查询用户
        $sql = "SELECT * FROM users WHERE username = ? AND status = 'active'";
        $user = $db->fetchOne($sql, [$username]);
        
        if (!$user) {
            return ['success' => false, 'message' => '用户名或密码错误'];
        }
        
        // 验证密码
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => '用户名或密码错误'];
        }
        
        // 更新最后登录时间
        $db->update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user['id']]);
        
        // 设置会话
        Session::login($user['id'], [
            'username' => $user['username'],
            'real_name' => $user['real_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'avatar' => $user['avatar']
        ]);
        
        return ['success' => true, 'message' => '登录成功'];
    }
    
    /**
     * 用户登出
     */
    public static function logout() {
        Session::logout();
    }
    
    /**
     * 检查用户是否已登录
     */
    public static function check() {
        return Session::isLoggedIn() && !Session::isExpired();
    }
    
    /**
     * 要求用户登录
     */
    public static function requireLogin() {
        if (!self::check()) {
            Session::setFlash('error', '请先登录');
            header('Location: /login');
            exit;
        }
    }
    
    /**
     * 获取当前用户信息
     */
    public static function user() {
        return Session::getUserData();
    }
    
    /**
     * 获取当前用户ID
     */
    public static function id() {
        return Session::getUserId();
    }
    
    /**
     * 检查用户角色
     */
    public static function hasRole($role) {
        $user = self::user();
        return isset($user['role']) && $user['role'] === $role;
    }
    
    /**
     * 检查用户是否为管理员
     */
    public static function isAdmin() {
        return self::hasRole('admin');
    }
    
    /**
     * 注册新用户
     */
    public static function register($data) {
        $db = Database::getInstance();
        
        // 检查用户名是否已存在
        $existing = $db->fetchOne("SELECT id FROM users WHERE username = ?", [$data['username']]);
        if ($existing) {
            return ['success' => false, 'message' => '用户名已存在'];
        }
        
        // 检查邮箱是否已存在
        if (!empty($data['email'])) {
            $existing = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$data['email']]);
            if ($existing) {
                return ['success' => false, 'message' => '邮箱已被使用'];
            }
        }
        
        // 验证密码长度
        if (strlen($data['password']) < PASSWORD_MIN_LENGTH) {
            return ['success' => false, 'message' => '密码长度不能少于' . PASSWORD_MIN_LENGTH . '个字符'];
        }
        
        // 创建用户
        $userData = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'real_name' => $data['real_name'] ?? '',
            'email' => $data['email'] ?? '',
            'role' => $data['role'] ?? 'teacher',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $userId = $db->insert('users', $userData);
        
        if ($userId) {
            return ['success' => true, 'message' => '注册成功', 'user_id' => $userId];
        }
        
        return ['success' => false, 'message' => '注册失败，请重试'];
    }
    
    /**
     * 修改密码
     */
    public static function changePassword($oldPassword, $newPassword) {
        $db = Database::getInstance();
        $userId = self::id();
        
        // 获取当前用户
        $user = $db->fetchOne("SELECT password FROM users WHERE id = ?", [$userId]);
        
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return ['success' => false, 'message' => '当前密码错误'];
        }
        
        if (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
            return ['success' => false, 'message' => '新密码长度不能少于' . PASSWORD_MIN_LENGTH . '个字符'];
        }
        
        // 更新密码
        $db->update('users', [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ], 'id = ?', [$userId]);
        
        return ['success' => true, 'message' => '密码修改成功'];
    }
    
    /**
     * 重置密码（管理员功能）
     */
    public static function resetPassword($userId, $newPassword) {
        $db = Database::getInstance();
        
        if (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
            return ['success' => false, 'message' => '密码长度不能少于' . PASSWORD_MIN_LENGTH . '个字符'];
        }
        
        $db->update('users', [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ], 'id = ?', [$userId]);
        
        return ['success' => true, 'message' => '密码重置成功'];
    }
}