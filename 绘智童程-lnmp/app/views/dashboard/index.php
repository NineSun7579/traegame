<?php
// 仪表板视图
$this->displayWithLayout('dashboard/content', 'main', [
    'pageTitle' => $pageTitle ?? '数据概览',
    'pageSubtitle' => '系统数据统计和图表展示',
    'currentUser' => $currentUser ?? [],
    'stats' => $stats ?? [],
    'recentActivities' => $recentActivities ?? [],
    'courseProgress' => $courseProgress ?? [],
    'deviceStatus' => $deviceStatus ?? []
]);
?>