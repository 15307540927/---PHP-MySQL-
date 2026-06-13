<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社区环保志愿 - 共建绿色家园</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        :root {
            --hero-gradient: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            --bg-pattern: 
                radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(4, 120, 87, 0.05) 0%, transparent 50%);
        }

        body {
            background: var(--bg-pattern);
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
        }

        .navbar .logo {
            font-size: 1.5rem;
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
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #4ade80, #22c55e);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .navbar-nav {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .navbar-nav a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .navbar-nav a:hover {
            color: white;
        }

        .navbar-nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #4ade80, #22c55e);
            transition: width 0.3s ease;
        }

        .navbar-nav a:hover::after {
            width: 100%;
        }

        .hero {
            background: var(--hero-gradient);
            padding: 6rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            position: relative;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.6s ease-out;
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto 2rem;
            position: relative;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            position: relative;
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-hero-primary {
            background: white;
            color: #059669;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(255, 255, 255, 0.4);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .features {
            padding: 5rem 2rem;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid rgba(34, 197, 94, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%);
            transition: transform 0.5s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(34, 197, 94, 0.15);
        }

        .feature-card:hover::before {
            transform: scale(2);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
            color: white;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #166534;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #52525b;
            line-height: 1.7;
        }

        .main-content {
            padding: 5rem 2rem;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #6b7280;
            max-width: 500px;
            margin: 0 auto;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .activity-card {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .activity-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .activity-image {
            height: 180px;
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
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%);
            background-size: 20px 20px;
            animation: animatePattern 20s linear infinite;
        }

        .activity-icon {
            font-size: 3.5rem;
            color: white;
            position: relative;
            z-index: 1;
        }

        .activity-content {
            padding: 1.75rem;
        }

        .activity-content h3 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.4;
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
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signup-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .signup-count {
            font-weight: 700;
            color: #22c55e;
        }

        .signup-total {
            color: #9ca3af;
        }

        .progress-bar {
            width: 80px;
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .btn-signup {
            padding: 0.75rem 1.75rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45);
        }

        .btn-signup:disabled,
        .btn-signup.disabled {
            background: #d1d5db;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .sidebar {
            background: white;
            border-radius: 1.25rem;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .suggest-form .form-group {
            margin-bottom: 1.25rem;
        }

        .suggest-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .suggest-form input,
        .suggest-form textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .suggest-form input:focus,
        .suggest-form textarea:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        .suggest-form textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45);
        }

        .footer {
            background: #1f2937;
            padding: 4rem 2rem;
            margin-top: 5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
        }

        .footer-section p,
        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: #22c55e;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .call-to-action {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 4rem 2rem;
            margin: 3rem auto;
            max-width: 800px;
            border-radius: 1.5rem;
            text-align: center;
            border: 1px solid rgba(34, 197, 94, 0.15);
        }

        .call-to-action h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #166534;
            margin-bottom: 1rem;
        }

        .call-to-action p {
            color: #52525b;
            margin-bottom: 2rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes animatePattern {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 20px 20px;
            }
        }

        @media (max-width: 768px) {
            .navbar .container {
                padding: 1rem;
            }

            .navbar-nav {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .activity-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
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
            <ul class="navbar-nav">
                <li><a href="index.php">首页</a></li>
                <li><a href="activity.php">志愿活动</a></li>
                <li><a href="suggest.php">意见反馈</a></li>
                <li><a href="admin_login.php" style="color: #ef4444; font-weight: 600;">后台管理</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <h1>共建绿色家园</h1>
        <p>参与志愿活动，守护身边的美好环境，让社区更绿，生活更美</p>
        <div class="hero-buttons">
            <a href="activity.php" class="btn btn-hero btn-hero-primary">立即参与</a>
            <a href="suggest.php" class="btn btn-hero btn-hero-secondary">提出建议</a>
        </div>
    </section>

    <section class="features">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>环保行动</h3>
                <p>参与各类环保志愿活动，为社区环境贡献力量，让绿色理念深入人心。</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>社区共建</h3>
                <p>汇聚社区力量，共同参与环保事业，营造和谐美好的居住环境。</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <h3>智慧环保</h3>
                <p>收集居民建议，采纳环保智慧，持续改进社区环保工作。</p>
            </div>
        </div>
    </section>

    <section class="main-content">
        <div class="section-title">
            <h2>最新志愿活动</h2>
            <p>参与我们的志愿活动，为环保事业贡献自己的一份力量</p>
        </div>
        
        <div class="activity-grid">
            <?php
            include 'conn.php';
            try {
                $sql = "SELECT * FROM volunteer_activities ORDER BY activity_time DESC LIMIT 3";
                $stmt = $pdo->query($sql);
                
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $activityTime = date('Y-m-d H:i', strtotime($row['activity_time']));
                        $signupRate = ($row['signup_num'] / $row['max_num']) * 100;
                        $isFull = $row['signup_num'] >= $row['max_num'];
                        
                        echo '<div class="activity-card animate-fade-in">';
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
                        echo '<span class="signup-count">' . $row['signup_num'] . '</span>';
                        echo '<span class="signup-total">/' . $row['max_num'] . '人</span>';
                        echo '<div class="progress-bar"><div class="progress-fill" style="width:' . $signupRate . '%"></div></div>';
                        echo '</div>';
                        echo '<a href="' . ($isFull ? 'javascript:void(0);' : 'signup.php?activity_id=' . $row['id']) . '" class="btn-signup' . ($isFull ? ' disabled" disabled' : '"') . '>' . ($isFull ? '名额已满' : '立即报名') . '</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #9ca3af;">';
                    echo '<div style="font-size: 4rem; margin-bottom: 1rem;">🌱</div>';
                    echo '<h3 style="font-size: 1.25rem; color: #6b7280;">暂无志愿活动</h3>';
                    echo '<p>管理员可在后台添加活动</p>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                die("查询失败：" . $e->getMessage());
            }
            ?>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="activity.php" class="btn btn-secondary" style="font-size: 1rem; padding: 0.875rem 2rem;">查看更多活动</a>
        </div>
    </section>

    <section class="main-content">
        <div class="container" style="max-width: 800px;">
            <div class="sidebar">
                <h3>环保意见反馈</h3>
                <form action="submit_suggest.php" method="post" class="suggest-form">
                    <div class="form-group">
                        <label for="username">您的称呼</label>
                        <input type="text" id="username" name="username" required placeholder="请输入您的姓名">
                    </div>
                    <div class="form-group">
                        <label for="content">环保建议</label>
                        <textarea id="content" name="content" required placeholder="例如：增加社区垃圾分类宣传..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">提交建议</button>
                </form>
            </div>
        </div>
    </section>

    <section class="call-to-action">
        <h3>加入我们，一起守护绿色家园</h3>
        <p>每一个小小的环保行动，都是对地球最好的爱护</p>
        <a href="activity.php" class="btn btn-primary btn-hero btn-hero-primary" style="display: inline-block;">立即参与志愿活动</a>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>关于我们</h4>
                <p>社区环保志愿平台致力于组织各类环保志愿活动，汇聚社区力量，共同守护美好环境。</p>
            </div>
            <div class="footer-section">
                <h4>快速链接</h4>
                <ul class="footer-links">
                    <li><a href="index.php">首页</a></li>
                    <li><a href="activity.php">志愿活动</a></li>
                    <li><a href="suggest.php">意见反馈</a></li>
                    <li><a href="admin_login.php">后台管理</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>联系我们</h4>
                <p>邮箱：contact@eco-volunteer.com</p>
                <p>电话：400-888-8888</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 社区环保志愿平台 版权所有 | 让社区更绿，生活更美</p>
        </div>
    </footer>
</body>
</html>