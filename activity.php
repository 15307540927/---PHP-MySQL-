<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>志愿活动列表 - 社区环保志愿</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
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
            max-width: 1400px;
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .activity-card {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .activity-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .card-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
        }

        .badge-full {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .badge-hot {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .activity-image {
            height: 200px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .activity-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.08) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.08) 50%, rgba(255, 255, 255, 0.08) 75%, transparent 75%);
            background-size: 30px 30px;
            animation: animatePattern 25s linear infinite;
        }

        .activity-icon {
            font-size: 4rem;
            color: white;
            position: relative;
            z-index: 1;
        }

        .activity-content {
            padding: 1.75rem;
        }

        .activity-content h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            padding: 0.5rem 0.875rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .meta-item svg {
            width: 16px;
            height: 16px;
            color: #22c55e;
        }

        .activity-desc {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.25rem;
            border-top: 1px solid #f3f4f6;
        }

        .signup-status {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .signup-info {
            display: flex;
            align-items: baseline;
            gap: 0.25rem;
        }

        .signup-count {
            font-weight: 700;
            font-size: 1.25rem;
            color: #22c55e;
        }

        .signup-total {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .progress-bar {
            width: 100px;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .btn-signup {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(34, 197, 94, 0.38);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-signup:hover:not(.disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(34, 197, 94, 0.45);
        }

        .btn-signup.disabled {
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
            cursor: not-allowed;
            box-shadow: none;
        }

        .empty-state {
            grid-column: 1 / -1;
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

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            background: white;
            color: #22c55e;
            border: 2px solid #22c55e;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background: #f0fdf4;
        }

        @keyframes animatePattern {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 30px 30px;
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

            .activity-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .activity-card {
                border-radius: 1rem;
            }

            .activity-image {
                height: 160px;
            }

            .activity-content {
                padding: 1.25rem;
            }

            .activity-content h3 {
                font-size: 1.25rem;
            }

            .activity-meta {
                gap: 0.5rem;
            }

            .meta-item {
                font-size: 0.75rem;
                padding: 0.375rem 0.625rem;
            }

            .btn-signup {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
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
                <a href="activity.php" style="color: #4ade80;">志愿活动</a>
                <a href="suggest.php">意见反馈</a>
                <a href="admin_login.php">后台管理</a>
            </div>
        </div>
    </nav>

    <header class="page-header">
        <h1>志愿活动列表</h1>
        <p>参与环保志愿活动，为社区环境贡献力量</p>
    </header>

    <div class="container">
        <a href="index.php" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 19l-7-7 7-7"/>
            </svg>
            返回首页
        </a>

        <div class="activity-grid">
            <?php
            try {
                $sql = "SELECT * FROM volunteer_activities ORDER BY activity_time DESC";
                $stmt = $pdo->query($sql);
                
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $activityTime = date('Y-m-d H:i', strtotime($row['activity_time']));
                        $signupRate = ($row['signup_num'] / $row['max_num']) * 100;
                        $isFull = $row['signup_num'] >= $row['max_num'];
                        $isHot = $signupRate >= 70;
                        
                        echo '<div class="activity-card">';
                        
                        if ($isFull) {
                            echo '<div class="card-badge"><span class="badge-full">名额已满</span></div>';
                        } elseif ($isHot) {
                            echo '<div class="card-badge"><span class="badge-hot">热门</span></div>';
                        }
                        
                        echo '<div class="activity-image">';
                        echo '<span class="activity-icon">🌍</span>';
                        echo '</div>';
                        
                        echo '<div class="activity-content">';
                        echo '<h3>' . htmlspecialchars($row['activity_name']) . '</h3>';
                        echo '<div class="activity-meta">';
                        echo '<span class="meta-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3"/></svg> ' . $activityTime . '</span>';
                        echo '<span class="meta-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> ' . htmlspecialchars($row['activity_address']) . '</span>';
                        echo '</div>';
                        echo '<p class="activity-desc">' . htmlspecialchars($row['activity_desc']) . '</p>';
                        
                        echo '<div class="activity-footer">';
                        echo '<div class="signup-status">';
                        echo '<div class="signup-info">';
                        echo '<span class="signup-count">' . $row['signup_num'] . '</span>';
                        echo '<span class="signup-total">/' . $row['max_num'] . '人</span>';
                        echo '</div>';
                        echo '<div class="progress-bar"><div class="progress-fill" style="width:' . $signupRate . '%"></div></div>';
                        echo '</div>';
                        echo '<a href="' . ($isFull ? 'javascript:void(0);' : 'signup.php?activity_id=' . $row['id']) . '" class="btn-signup' . ($isFull ? ' disabled' : '') . '">';
                        echo $isFull ? '名额已满' : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 11h5l-5 5v-5z"/><path d="M4 19h16v-7a4 4 0 0 0-8-3 4 4 0 0 0-8 3v7z"/></svg> 立即报名';
                        echo '</a>';
                        echo '</div>';
                        
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-state">';
                    echo '<div class="empty-icon">🌱</div>';
                    echo '<h3>暂无志愿活动</h3>';
                    echo '<p>请联系管理员添加活动，或返回首页浏览其他内容</p>';
                    echo '<a href="index.php" class="btn-signup" style="display: inline-block;">返回首页</a>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="empty-state">';
                echo '<div class="empty-icon">⚠️</div>';
                echo '<h3>加载失败</h3>';
                echo '<p>获取活动列表时出现错误，请稍后重试</p>';
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