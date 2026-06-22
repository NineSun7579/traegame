<?php
/**
 * 绘智童程 - 应用配置文件
 */

// 应用配置
define('APP_NAME', '绘智童程');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);
define('APP_TIMEZONE', 'Asia/Shanghai');

// 数据库配置
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'huizhitongcheng');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// 会话配置
define('SESSION_LIFETIME', 3600); // 1小时
define('SESSION_NAME', 'HZTC_SESSION');

// 安全配置
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 6);

// 文件上传配置
define('UPLOAD_MAX_SIZE', 10 * 1024 * 1024); // 10MB
define('UPLOAD_ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword']);
define('UPLOAD_PATH', APP_ROOT . '/public/uploads/');

// 分页配置
define('ITEMS_PER_PAGE', 20);

// 邮件配置（可选）
define('MAIL_HOST', '');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_FROM_ADDRESS', '');
define('MAIL_FROM_NAME', APP_NAME);

// 缓存配置
define('CACHE_ENABLED', false);
define('CACHE_LIFETIME', 3600);
define('CACHE_PATH', APP_ROOT . '/storage/cache/');

// 日志配置
define('LOG_ENABLED', true);
define('LOG_PATH', APP_ROOT . '/storage/logs/');

// API配置
define('API_ENABLED', true);
define('API_KEY', ''); // 可选的API密钥

// 站点URL
define('SITE_URL', 'http://localhost');
define('ASSETS_URL', SITE_URL . '/assets');