<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? '绘智童程') ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🤖</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-primary: #0a0e1a;
            --bg-secondary: #111827;
            --bg-card: #1f2937;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --accent-blue: #38bdf8;
            --accent-green: #34d399;
            --accent-purple: #a78bfa;
            --accent-orange: #fbbf24;
            --accent-red: #ff6b6b;
            --sidebar-width: 240px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans SC', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-secondary);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 0;
            overflow-y: auto;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 20px;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
        }
        
        .sidebar-logo-icon {
            font-size: 24px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.1), rgba(167, 139, 250, 0.1));
            color: var(--accent-blue);
            border-right: 3px solid var(--accent-blue);
        }
        
        .nav-icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        
        .page-header {
            margin-bottom: 24px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .page-subtitle {
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        .content-area {
            /* 内容区域样式 */
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            color: white;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
        }
        
        .user-menu {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: var(--bg-card);
            border-radius: 8px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        
        .user-name {
            font-size: 14px;
            color: var(--text-primary);
        }
        
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: var(--bg-card);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 150px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            display: none;
        }
        
        .user-dropdown.show {
            display: block;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span class="sidebar-logo-icon">🤖</span>
                <span>绘智童程</span>
            </div>
        </div>
        
        <a href="/dashboard" class="nav-item <?= ($pageTitle ?? '') === '数据概览' ? 'active' : '' ?>">
            <span class="nav-icon">📊</span>
            <span>数据概览</span>
        </a>
        
        <a href="/courses" class="nav-item <?= ($pageTitle ?? '') === '课程管理' ? 'active' : '' ?>">
            <span class="nav-icon">📚</span>
            <span>课程管理</span>
        </a>
        
        <a href="/students" class="nav-item <?= ($pageTitle ?? '') === '学员管理' ? 'active' : '' ?>">
            <span class="nav-icon">🎓</span>
            <span>学员管理</span>
        </a>
        
        <a href="/devices" class="nav-item <?= ($pageTitle ?? '') === '设备管理' ? 'active' : '' ?>">
            <span class="nav-icon">🤖</span>
            <span>设备管理</span>
        </a>
        
        <a href="/lessons" class="nav-item <?= ($pageTitle ?? '') === '课时计划' ? 'active' : '' ?>">
            <span class="nav-icon">📅</span>
            <span>课时计划</span>
        </a>
        
        <a href="/resources" class="nav-item <?= ($pageTitle ?? '') === '资源库' ? 'active' : '' ?>">
            <span class="nav-icon">📁</span>
            <span>资源库</span>
        </a>
        
        <a href="/cards" class="nav-item <?= ($pageTitle ?? '') === '编程卡片' ? 'active' : '' ?>">
            <span class="nav-icon">🎴</span>
            <span>编程卡片</span>
        </a>
        
        <a href="/analytics" class="nav-item <?= ($pageTitle ?? '') === '学习分析' ? 'active' : '' ?>">
            <span class="nav-icon">📈</span>
            <span>学习分析</span>
        </a>
        
        <a href="/settings" class="nav-item <?= ($pageTitle ?? '') === '系统设置' ? 'active' : '' ?>">
            <span class="nav-icon">⚙️</span>
            <span>系统设置</span>
        </a>
    </div>
    
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title"><?= htmlspecialchars($pageTitle ?? '页面标题') ?></h1>
            <p class="page-subtitle"><?= htmlspecialchars($pageSubtitle ?? '') ?></p>
        </div>
        
        <div class="content-area">
            <?= $content ?? '' ?>
        </div>
    </div>
    
    <div class="user-menu" onclick="toggleUserDropdown()">
        <div class="user-avatar">
            <?= mb_substr($currentUser['real_name'] ?? '用', 0, 1) ?>
        </div>
        <span class="user-name"><?= htmlspecialchars($currentUser['real_name'] ?? '用户') ?></span>
        
        <div class="user-dropdown" id="userDropdown">
            <a href="/settings" class="dropdown-item">
                <span>⚙️</span>
                <span>个人设置</span>
            </a>
            <a href="/logout" class="dropdown-item">
                <span>🚪</span>
                <span>退出登录</span>
            </a>
        </div>
    </div>
    
    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }
        
        // 点击其他地方关闭下拉菜单
        document.addEventListener('click', function(e) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (!userMenu.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>