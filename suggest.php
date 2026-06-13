<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>环保意见 - 社区环保志愿</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
        }

        .navbar {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar .logo {
            font-size: 1.35rem;
            font-weight: 700;
            background: linear-gradient(135deg, #4ade80, #22c55e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar .logo-icon {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #4ade80, #22c55e);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }

        .navbar-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }

        .navbar-links a:hover {
            color: white;
        }

        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #4ade80, #22c55e);
            transition: width 0.3s ease;
        }

        .navbar-links a:hover::after {
            width: 100%;
        }

        .page-header {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2.5L25 20l-5 4.5V22h20v2H20v2.5L15 20l5-4.5V18H0v2h20v2.5z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.75rem;
            position: relative;
        }

        .page-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #22c55e;
            border: 2px solid #22c55e;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            display: inline-flex;
        }

        .back-link:hover {
            background: #f0fdf4;
        }

        .suggestions-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .suggestion-card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out backwards;
        }

        .suggestion-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .suggestion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 1rem;
        }

        .submit-time {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .badge {
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-approved {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
        }

        .badge-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .suggestion-content {
            background: #f9fafb;
            padding: 1.25rem;
            border-radius: 10px;
            margin-top: 0.75rem;
        }

        .suggestion-content p {
            color: #4b5563;
            line-height: 1.7;
            font-size: 0.95rem;
            white-space: pre-wrap;
        }

        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .stats-bar {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .stat-item {
            flex: 1;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #22c55e;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .navbar .container {
                padding: 1rem;
            }

            .navbar-links {
                gap: 1rem;
            }

            .page-header h1 {
                font-size: 1.75rem;
            }

            .container {
                padding: 2rem 1rem;
            }

            .suggestion-card {
                padding: 1.25rem;
            }

            .suggestion-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .stats-bar {
                flex-direction: column;
                gap: 1.25rem;
            }

            .stat-item {
                padding-bottom: 1rem;
                border-bottom: 1px solid #f3f4f6;
            }

            .stat-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <span class="logo-icon">🌱</span>
                社区环保志愿
            </a>
            <div class="navbar-links">
                <a href="index.php">首页</a>
                <a href="activity.php">志愿活动</a>
                <a href="suggest.php" style="color: #4ade80;">意见反馈</a>
                <a href="admin_login.php">后台管理</a>
            </div>
        </div>
    </nav>

    <header class="page-header">
        <h1>环保建议墙</h1>
        <p>倾听您的声音，共建绿色家园</p>
    </header>

    <div class="container">
        <a href="index.php" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 19l-7-7 7-7"/>
            </svg>
            返回首页
        </a>

        <?php
        try {
            $totalSql = "SELECT COUNT(*) as total FROM env_suggestions";
            $approvedSql = "SELECT COUNT(*) as approved FROM env_suggestions WHERE status = 1";
            
            $totalStmt = $pdo->query($totalSql);
            $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $approvedStmt = $pdo->query($approvedSql);
            $approved = $approvedStmt->fetch(PDO::FETCH_ASSOC)['approved'];
            
            echo '<div class="stats-bar">';
            echo '<div class="stat-item">';
            echo '<div class="stat-value">' . $total . '</div>';
            echo '<div class="stat-label">总建议数</div>';
            echo '</div>';
            echo '<div class="stat-item">';
            echo '<div class="stat-value">' . $approved . '</div>';
            echo '<div class="stat-label">已采纳</div>';
            echo '</div>';
            echo '<div class="stat-item">';
            echo '<div class="stat-value">' . ($total - $approved) . '</div>';
            echo '<div class="stat-label">待审核</div>';
            echo '</div>';
            echo '</div>';
        } catch (PDOException $e) {
            // 忽略统计错误
        }
        ?>

        <div class="suggestions-list">
            <?php
            try {
                $sql = "SELECT * FROM env_suggestions ORDER BY submit_time DESC";
                $stmt = $pdo->query($sql);

                if ($stmt->rowCount() > 0) {
                    $index = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $index++;
                        $statusClass = $row['status'] == 1 ? 'badge-approved' : 'badge-pending';
                        $statusText = $row['status'] == 1 ? '已采纳' : '待审核';
                        $firstChar = mb_substr($row['username'], 0, 1);
                        
                        echo '<div class="suggestion-card" style="animation-delay: ' . ($index * 0.1) . 's;">';
                        echo '<div class="suggestion-header">';
                        echo '<div class="user-info">';
                        echo '<div class="user-avatar">' . htmlspecialchars($firstChar) . '</div>';
                        echo '<div>';
                        echo '<div class="user-name">' . htmlspecialchars($row['username']) . '</div>';
                        echo '<div class="submit-time">' . $row['submit_time'] . '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<span class="badge ' . $statusClass . '">' . $statusText . '</span>';
                        echo '</div>';
                        echo '<div class="suggestion-content">';
                        echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-state">';
                    echo '<div class="empty-icon">💡</div>';
                    echo '<h3>还没有建议哦</h3>';
                    echo '<p>快去首页提交第一个建议吧！</p>';
                    echo '<a href="index.php" class="btn btn-primary" style="display: inline-block;">去提交建议</a>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="empty-state">';
                echo '<div class="empty-icon">⚠️</div>';
                echo '<h3>加载失败</h3>';
                echo '<p>获取建议列表时出现错误，请稍后重试</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <footer style="background: #1f2937; padding: 3rem 2rem; margin-top: 4rem;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <p style="color: #9ca3af; font-size: 0.875rem;">© 2026 社区环保志愿平台 版权所有</p>
        </div>
    </footer>
</body>
</html>