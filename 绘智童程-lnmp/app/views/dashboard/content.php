<?php
// 仪表板内容视图
?>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    
    .stat-title {
        color: var(--text-secondary);
        font-size: 14px;
    }
    
    .stat-icon {
        font-size: 24px;
        opacity: 0.8;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .stat-change {
        font-size: 13px;
        color: var(--accent-green);
    }
    
    .stat-change.negative {
        color: var(--accent-red);
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .chart-title {
        font-size: 16px;
        font-weight: 600;
    }
    
    .chart-container {
        height: 300px;
        position: relative;
    }
    
    .activity-list {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .activity-title {
        font-size: 16px;
        font-weight: 600;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-text {
        font-size: 14px;
        margin-bottom: 4px;
    }
    
    .activity-time {
        font-size: 12px;
        color: var(--text-secondary);
    }
    
    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">活跃课程</span>
            <span class="stat-icon">📚</span>
        </div>
        <div class="stat-value"><?= $stats['active_courses'] ?? 0 ?></div>
        <div class="stat-change">↑ 12% 较上月</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">在线学员</span>
            <span class="stat-icon">🎓</span>
        </div>
        <div class="stat-value"><?= $stats['total_students'] ?? 0 ?></div>
        <div class="stat-change">↑ 8% 较上月</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">设备在线</span>
            <span class="stat-icon">🤖</span>
        </div>
        <div class="stat-value"><?= $stats['online_devices'] ?? 0 ?></div>
        <div class="stat-change negative">↓ 3 较昨日</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">学习时长</span>
            <span class="stat-icon">⏰</span>
        </div>
        <div class="stat-value"><?= number_format(($stats['learning_hours'] ?? 0) / 60, 1) ?>h</div>
        <div class="stat-change">↑ 15% 较上月</div>
    </div>
</div>

<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">学习趋势</h3>
            <select class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                <option>最近7天</option>
                <option>最近30天</option>
                <option>最近90天</option>
            </select>
        </div>
        <div class="chart-container">
            <canvas id="trendChart"></canvas>
        </div>
    </div>
    
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">课程分布</h3>
            <select class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                <option>按课程</option>
                <option>按级别</option>
                <option>按年龄</option>
            </select>
        </div>
        <div class="chart-container">
            <canvas id="distributionChart"></canvas>
        </div>
    </div>
</div>

<div class="activity-list">
    <div class="activity-header">
        <h3 class="activity-title">最近活动</h3>
        <button class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">查看全部</button>
    </div>
    
    <?php if (!empty($recentActivities)): ?>
        <?php foreach ($recentActivities as $activity): ?>
        <div class="activity-item">
            <div class="activity-icon" style="background: rgba(56, 189, 248, 0.1);">
                <?= $activity['action'] === 'login' ? '🔑' : ($activity['action'] === 'create' ? '➕' : '📝') ?>
            </div>
            <div class="activity-content">
                <div class="activity-text">
                    <strong><?= htmlspecialchars($activity['user_name'] ?? '系统') ?></strong>
                    <?= htmlspecialchars($activity['description'] ?? '') ?>
                </div>
                <div class="activity-time"><?= htmlspecialchars($activity['created_at'] ?? '') ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="activity-item">
            <div class="activity-icon" style="background: rgba(52, 211, 153, 0.1);">
                ✅
            </div>
            <div class="activity-content">
                <div class="activity-text">系统运行正常</div>
                <div class="activity-time"><?= date('Y-m-d H:i:s') ?></div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// 学习趋势图表
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
        datasets: [{
            label: '学习时长（分钟）',
            data: [120, 190, 150, 220, 180, 250, 200],
            borderColor: '#38bdf8',
            backgroundColor: 'rgba(56, 189, 248, 0.1)',
            fill: true,
            tension: 0.4
        }, {
            label: '完成课程数',
            data: [5, 8, 6, 10, 7, 12, 9],
            borderColor: '#34d399',
            backgroundColor: 'rgba(52, 211, 153, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: '#94a3b8'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.05)'
                },
                ticks: {
                    color: '#94a3b8'
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.05)'
                },
                ticks: {
                    color: '#94a3b8'
                }
            }
        }
    }
});

// 课程分布图表
const distCtx = document.getElementById('distributionChart').getContext('2d');
new Chart(distCtx, {
    type: 'doughnut',
    data: {
        labels: ['入门课程', '基础课程', '进阶课程', '高级课程'],
        datasets: [{
            data: [30, 25, 20, 15],
            backgroundColor: [
                'rgba(52, 211, 153, 0.8)',
                'rgba(56, 189, 248, 0.8)',
                'rgba(251, 191, 36, 0.8)',
                'rgba(167, 139, 250, 0.8)'
            ],
            borderColor: '#1f2937',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#94a3b8',
                    padding: 20
                }
            }
        }
    }
});
</script>