-- 插入默认管理员用户
-- 密码: admin123 (使用PHP password_hash生成)
INSERT INTO `users` (`username`, `password`, `real_name`, `email`, `role`, `status`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '系统管理员', 'admin@huizhitongcheng.com', 'admin', 'active'),
('teacher1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '张老师', 'zhang@huizhitongcheng.com', 'teacher', 'active'),
('teacher2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '李老师', 'li@huizhitongcheng.com', 'teacher', 'active');

-- 插入课程数据
INSERT INTO `courses` (`name`, `level`, `age_min`, `age_max`, `lessons`, `description`, `icon`, `status`, `created_by`) VALUES
('认识编程：小机器人回家', 'beginner', 3, 4, 8, '通过简单的方向指令，引导小机器人回到家中。培养孩子的方向感和基础逻辑思维。', '🌱', 'active', 1),
('方向认知：前进后退左转右转', 'beginner', 3, 4, 6, '学习基本的方向概念，掌握前进、后退、左转、右转等基础指令。', '🌿', 'active', 1),
('循环魔法：重复的力量', 'intermediate', 4, 6, 10, '理解循环的概念，学会使用重复指令简化编程步骤。', '🌳', 'active', 1),
('条件判断：如果...就...', 'intermediate', 4, 6, 12, '学习条件判断语句，让程序能够根据不同情况做出不同反应。', '🌲', 'active', 1),
('智能避障小车', 'advanced', 6, 8, 16, '综合运用传感器和编程知识，制作能够自动避障的智能小车。', '🚗', 'active', 1),
('声音编程：音乐盒', 'beginner', 3, 4, 6, '通过编程控制声音模块，创作简单的音乐旋律。', '🎵', 'active', 1),
('LED灯光秀', 'beginner', 3, 5, 8, '学习控制LED灯，创造各种灯光效果和图案。', '💡', 'active', 1),
('循迹机器人', 'intermediate', 5, 7, 14, '制作能够沿着黑线行走的循迹机器人。', '🤖', 'active', 1),
('超声波测距', 'advanced', 6, 8, 10, '学习使用超声波传感器测量距离，应用于避障和测距场景。', '📡', 'active', 1),
('温度传感器实验', 'advanced', 6, 8, 8, '使用温度传感器测量环境温度，学习数据采集和处理。', '🌡️', 'active', 1),
('小车组装入门', 'beginner', 4, 6, 4, '学习基本的小车组装知识，了解机械结构。', '🔧', 'active', 1),
('并行执行：双机器人协作', 'advanced', 7, 9, 12, '学习多任务并行执行，让两个机器人协同工作。', '🤝', 'active', 1);

-- 插入学员数据
INSERT INTO `students` (`name`, `age`, `gender`, `parent_name`, `parent_phone`, `class_name`, `current_course_id`, `score`, `progress`, `status`, `enrollment_date`) VALUES
('小明', 5, 'male', '张父', '13800138001', '启蒙1班', 1, 920, 85.00, 'active', '2024-01-15'),
('小红', 4, 'female', '李母', '13800138002', '启蒙1班', 2, 880, 72.00, 'active', '2024-01-15'),
('小华', 6, 'male', '王父', '13800138003', '基础2班', 3, 956, 90.00, 'active', '2024-02-01'),
('小丽', 5, 'female', '赵母', '13800138004', '启蒙1班', 1, 780, 60.00, 'active', '2024-02-01'),
('小强', 7, 'male', '刘父', '13800138005', '进阶1班', 5, 1020, 45.00, 'active', '2024-02-15'),
('小美', 4, 'female', '陈母', '13800138006', '启蒙1班', 6, 850, 78.00, 'active', '2024-02-15'),
('小刚', 6, 'male', '杨父', '13800138007', '基础2班', 4, 900, 65.00, 'active', '2024-03-01'),
('小芳', 5, 'female', '周母', '13800138008', '启蒙1班', 7, 720, 55.00, 'active', '2024-03-01'),
('小伟', 8, 'male', '吴父', '13800138009', '进阶1班', 9, 1100, 30.00, 'active', '2024-03-15'),
('小燕', 4, 'female', '郑母', '13800138010', '启蒙1班', 1, 660, 30.00, 'active', '2024-03-15');

-- 插入设备数据
INSERT INTO `devices` (`device_code`, `name`, `type`, `status`, `battery`, `signal`, `classroom`, `last_sync`, `firmware_version`) VALUES
('HZ-001', '编程小车 A', 'robot', 'online', 85, 4, '启蒙1班', '2024-06-22 10:30:00', 'v2.1.0'),
('HZ-002', '编程小车 B', 'robot', 'online', 92, 5, '启蒙1班', '2024-06-22 10:31:00', 'v2.1.0'),
('HZ-003', '编程小车 C', 'robot', 'online', 67, 3, '基础2班', '2024-06-22 10:25:00', 'v2.1.0'),
('HZ-004', '编程小车 D', 'robot', 'offline', 12, 0, '待分配', '2024-06-20 15:00:00', 'v2.0.0'),
('HZ-005', '编程小车 E', 'robot', 'online', 78, 4, '基础2班', '2024-06-22 10:27:00', 'v2.1.0'),
('HZ-006', '传感器套件 A', 'sensor', 'online', 95, 5, '进阶1班', '2024-06-22 10:29:00', 'v1.5.0'),
('HZ-007', '传感器套件 B', 'sensor', 'idle', 100, 0, '待分配', '2024-06-15 09:00:00', 'v1.5.0'),
('HZ-008', 'LED矩阵板 A', 'led', 'online', 88, 4, '启蒙1班', '2024-06-22 10:26:00', 'v1.2.0'),
('HZ-009', '声音模块 A', 'audio', 'offline', 5, 0, '基础2班', '2024-06-21 14:00:00', 'v1.1.0'),
('HZ-010', '编程小车 F', 'robot', 'online', 73, 3, '进阶1班', '2024-06-22 10:24:00', 'v2.1.0'),
('HZ-011', '避障模块 A', 'sensor', 'online', 81, 4, '进阶1班', '2024-06-22 10:28:00', 'v1.3.0'),
('HZ-012', '编程小车 G', 'robot', 'idle', 95, 0, '待分配', '2024-06-08 11:00:00', 'v2.0.0');

-- 插入编程卡片数据
INSERT INTO `cards` (`name`, `category`, `description`, `icon`, `color`, `difficulty`, `status`) VALUES
('前进', '方向', '让机器人向前移动一步', '⬆️', '#34d399', 'easy', 'active'),
('后退', '方向', '让机器人向后移动一步', '⬇️', '#34d399', 'easy', 'active'),
('左转', '方向', '让机器人向左转90度', '⬅️', '#34d399', 'easy', 'active'),
('右转', '方向', '让机器人向右转90度', '➡️', '#34d399', 'easy', 'active'),
('跳跃', '动作', '让机器人跳跃一次', '⬆️', '#38bdf8', 'easy', 'active'),
('抓取', '动作', '让机器人抓取前方物体', '✋', '#38bdf8', 'medium', 'active'),
('放下', '动作', '让机器人放下抓取的物体', '🖐️', '#38bdf8', 'medium', 'active'),
('重复2次', '循环', '重复执行下一个动作2次', '🔄', '#f59e0b', 'easy', 'active'),
('重复3次', '循环', '重复执行下一个动作3次', '🔄', '#f59e0b', 'easy', 'active'),
('重复4次', '循环', '重复执行下一个动作4次', '🔄', '#f59e0b', 'easy', 'active'),
('重复5次', '循环', '重复执行下一个动作5次', '🔄', '#f59e0b', 'medium', 'active'),
('循环结束', '循环', '标记循环体结束', '🔁', '#f59e0b', 'medium', 'active'),
('如果前方有障碍', '条件', '检测前方是否有障碍物', '❓', '#a78bfa', 'medium', 'active'),
('如果左侧有路', '条件', '检测左侧是否有通行路径', '❓', '#a78bfa', 'medium', 'active'),
('如果右侧有路', '条件', '检测右侧是否有通行路径', '❓', '#a78bfa', 'medium', 'active'),
('如果到达终点', '条件', '检测是否到达目标位置', '❓', '#a78bfa', 'hard', 'active'),
('定义函数A', '函数', '开始定义函数A', '📦', '#e879f9', 'hard', 'active'),
('调用函数A', '函数', '执行函数A中的指令', '📦', '#e879f9', 'hard', 'active'),
('函数结束', '函数', '标记函数定义结束', '📦', '#e879f9', 'hard', 'active'),
('读取超声波', '传感器', '读取超声波传感器距离值', '📡', '#06b6d4', 'medium', 'active'),
('读取温度', '传感器', '读取温度传感器数值', '🌡️', '#06b6d4', 'medium', 'active'),
('读取光线', '传感器', '读取光线传感器数值', '☀️', '#06b6d4', 'medium', 'active'),
('检测颜色', '传感器', '检测前方物体颜色', '🎨', '#06b6d4', 'hard', 'active'),
('检测声音', '传感器', '检测环境声音大小', '🔊', '#06b6d4', 'medium', 'active'),
('设置变量X', '变量', '设置变量X的值', '📊', '#84cc16', 'medium', 'active'),
('设置变量Y', '变量', '设置变量Y的值', '📊', '#84cc16', 'medium', 'active'),
('增加变量', '变量', '将变量值加1', '➕', '#84cc16', 'medium', 'active'),
('减少变量', '变量', '将变量值减1', '➖', '#84cc16', 'medium', 'active'),
('显示变量', '变量', '在屏幕上显示变量值', '📊', '#84cc16', 'easy', 'active'),
('开始', '动作', '程序开始执行', '▶️', '#ff6b6b', 'easy', 'active'),
('结束', '动作', '程序执行结束', '⏹️', '#ff6b6b', 'easy', 'active'),
('暂停1秒', '动作', '暂停执行1秒钟', '⏸️', '#38bdf8', 'easy', 'active'),
('亮灯', '动作', '点亮LED灯', '💡', '#fbbf24', 'easy', 'active'),
('灭灯', '动作', '熄灭LED灯', '💡', '#94a3b8', 'easy', 'active'),
('播放声音', '动作', '播放预设的声音', '🔊', '#f59e0b', 'easy', 'active'),
('等待触摸', '动作', '等待触摸传感器触发', '👆', '#06b6d4', 'medium', 'active');

-- 插入系统设置
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', '绘智童程 · 无屏编程启蒙系统', 'string', '网站名称'),
('organization', '阳光幼儿园', 'string', '机构名称'),
('admin_email', 'admin@huizhitongcheng.com', 'string', '管理员邮箱'),
('contact_phone', '400-888-6666', 'string', '联系电话'),
('timezone', 'Asia/Shanghai', 'string', '系统时区'),
('auto_backup', '1', 'boolean', '自动备份'),
('data_encryption', '1', 'boolean', '数据加密'),
('maintenance_mode', '0', 'boolean', '维护模式');