<?php
/**
 * 仪表板控制器
 */

require_once APP_ROOT . '/app/core/Controller.php';

class DashboardController extends Controller {
    
    public function index() {
        // 检查登录状态
        Auth::requireLogin();
        
        $db = Database::getInstance();
        
        // 获取统计数据
        $stats = [
            'active_courses' => $db->fetchOne("SELECT COUNT(*) as count FROM courses WHERE status = 'active'")['count'] ?? 0,
            'total_students' => $db->fetchOne("SELECT COUNT(*) as count FROM students WHERE status = 'active'")['count'] ?? 0,
            'online_devices' => $db->fetchOne("SELECT COUNT(*) as count FROM devices WHERE status = 'online'")['count'] ?? 0,
            'learning_hours' => $db->fetchOne("SELECT SUM(time_spent) as total FROM learning_records")['total'] ?? 0
        ];
        
        // 获取最近活动
        $recentActivities = $db->fetchAll("
            SELECT ol.*, u.real_name as user_name 
            FROM operation_logs ol 
            LEFT JOIN users u ON ol.user_id = u.id 
            ORDER BY ol.created_at DESC 
            LIMIT 10
        ");
        
        // 获取课程进度
        $courseProgress = $db->fetchAll("
            SELECT c.name, c.icon, 
                   COUNT(s.id) as student_count,
                   AVG(s.progress) as avg_progress
            FROM courses c
            LEFT JOIN students s ON s.current_course_id = c.id
            WHERE c.status = 'active'
            GROUP BY c.id
            ORDER BY student_count DESC
            LIMIT 6
        ");
        
        // 获取设备状态
        $deviceStatus = $db->fetchAll("
            SELECT status, COUNT(*) as count
            FROM devices
            GROUP BY status
        ");
        
        $this->view('dashboard/index', [
            'pageTitle' => '数据概览',
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'courseProgress' => $courseProgress,
            'deviceStatus' => $deviceStatus,
            'currentUser' => Auth::user()
        ]);
    }
}