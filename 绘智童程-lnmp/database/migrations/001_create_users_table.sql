-- 创建用户表
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `real_name` VARCHAR(50) DEFAULT '',
    `email` VARCHAR(100) DEFAULT '',
    `phone` VARCHAR(20) DEFAULT '',
    `avatar` VARCHAR(255) DEFAULT '',
    `role` ENUM('admin', 'teacher', 'assistant') DEFAULT 'teacher',
    `status` ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建课程表
CREATE TABLE IF NOT EXISTS `courses` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `level` ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    `age_min` INT UNSIGNED DEFAULT 3,
    `age_max` INT UNSIGNED DEFAULT 8,
    `lessons` INT UNSIGNED DEFAULT 0,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT '',
    `status` ENUM('active', 'inactive', 'archived') DEFAULT 'active',
    `created_by` INT UNSIGNED,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_level` (`level`),
    INDEX `idx_status` (`status`),
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建学员表
CREATE TABLE IF NOT EXISTS `students` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `age` INT UNSIGNED DEFAULT 0,
    `gender` ENUM('male', 'female', 'other') DEFAULT 'other',
    `parent_name` VARCHAR(50) DEFAULT '',
    `parent_phone` VARCHAR(20) DEFAULT '',
    `parent_email` VARCHAR(100) DEFAULT '',
    `class_name` VARCHAR(50) DEFAULT '',
    `current_course_id` INT UNSIGNED DEFAULT NULL,
    `score` INT UNSIGNED DEFAULT 0,
    `progress` DECIMAL(5,2) DEFAULT 0.00,
    `status` ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
    `avatar` VARCHAR(255) DEFAULT '',
    `notes` TEXT,
    `enrollment_date` DATE DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_name` (`name`),
    INDEX `idx_class` (`class_name`),
    INDEX `idx_status` (`status`),
    FOREIGN KEY (`current_course_id`) REFERENCES `courses`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建设备表
CREATE TABLE IF NOT EXISTS `devices` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `device_code` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `type` VARCHAR(50) DEFAULT 'robot',
    `status` ENUM('online', 'offline', 'idle', 'maintenance') DEFAULT 'idle',
    `battery` INT UNSIGNED DEFAULT 100,
    `signal` INT UNSIGNED DEFAULT 0,
    `classroom` VARCHAR(50) DEFAULT '',
    `assigned_to` INT UNSIGNED DEFAULT NULL,
    `last_sync` DATETIME DEFAULT NULL,
    `firmware_version` VARCHAR(20) DEFAULT '',
    `notes` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_code` (`device_code`),
    INDEX `idx_status` (`status`),
    INDEX `idx_classroom` (`classroom`),
    FOREIGN KEY (`assigned_to`) REFERENCES `students`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建课时计划表
CREATE TABLE IF NOT EXISTS `lessons` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `course_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `lesson_number` INT UNSIGNED DEFAULT 0,
    `duration` INT UNSIGNED DEFAULT 45,
    `objectives` TEXT,
    `materials` TEXT,
    `status` ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_course` (`course_id`),
    INDEX `idx_status` (`status`),
    FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建资源表
CREATE TABLE IF NOT EXISTS `resources` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `type` ENUM('document', 'video', 'image', 'template', 'other') DEFAULT 'document',
    `file_path` VARCHAR(255) NOT NULL,
    `file_size` INT UNSIGNED DEFAULT 0,
    `file_type` VARCHAR(50) DEFAULT '',
    `description` TEXT,
    `download_count` INT UNSIGNED DEFAULT 0,
    `uploaded_by` INT UNSIGNED,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_type` (`type`),
    INDEX `idx_uploaded_by` (`uploaded_by`),
    FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建编程卡片表
CREATE TABLE IF NOT EXISTS `cards` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT '',
    `color` VARCHAR(20) DEFAULT '',
    `code_block` TEXT,
    `difficulty` ENUM('easy', 'medium', 'hard') DEFAULT 'easy',
    `usage_count` INT UNSIGNED DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`),
    INDEX `idx_difficulty` (`difficulty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建学习记录表
CREATE TABLE IF NOT EXISTS `learning_records` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NOT NULL,
    `course_id` INT UNSIGNED NOT NULL,
    `lesson_id` INT UNSIGNED DEFAULT NULL,
    `score` INT UNSIGNED DEFAULT 0,
    `progress` DECIMAL(5,2) DEFAULT 0.00,
    `time_spent` INT UNSIGNED DEFAULT 0,
    `completed` TINYINT(1) DEFAULT 0,
    `notes` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_student` (`student_id`),
    INDEX `idx_course` (`course_id`),
    INDEX `idx_lesson` (`lesson_id`),
    FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`lesson_id`) REFERENCES `lessons`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建系统设置表
CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(50) NOT NULL UNIQUE,
    `setting_value` TEXT,
    `setting_type` ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    `description` VARCHAR(255) DEFAULT '',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建操作日志表
CREATE TABLE IF NOT EXISTS `operation_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED DEFAULT NULL,
    `action` VARCHAR(50) NOT NULL,
    `target_type` VARCHAR(50) DEFAULT '',
    `target_id` INT UNSIGNED DEFAULT NULL,
    `description` TEXT,
    `ip_address` VARCHAR(45) DEFAULT '',
    `user_agent` VARCHAR(255) DEFAULT '',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_action` (`action`),
    INDEX `idx_target` (`target_type`, `target_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;