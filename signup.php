<?php
require 'conn.php';

$activityId = intval($_GET['activity_id'] ?? 0);
if ($activityId == 0) {
    echo "<script>alert('无效的活动ID！'); window.location.href='activity.php';</script>";
    exit;
}

try {
    $sql = "SELECT * FROM volunteer_activities WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $activityId]);
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("查询失败：" . $e->getMessage());
}

if (!$activity) {
    echo "<script>alert('该志愿活动不存在！'); window.location.href='activity.php';</script>";
    exit;
}

if ($activity['signup_num'] >= $activity['max_num']) {
    echo "<script>alert('该活动名额已满，无法报名！'); window.location.href='activity.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $idCard = trim($_POST['id_card'] ?? '');

    try {
        $checkSql = "SELECT * FROM volunteer_signups WHERE activity_id = :activity_id AND phone = :phone";
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([':activity_id' => $activityId, ':phone' => $phone]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('该手机号已报名此活动，无需重复报名！'); window.history.back();</script>";
            exit;
        }

        $insertSql = "INSERT INTO volunteer_signups (activity_id, username, phone, id_card) VALUES (:activity_id, :username, :phone, :id_card)";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([
            ':activity_id' => $activityId,
            ':username' => $username,
            ':phone' => $phone,
            ':id_card' => $idCard
        ]);

        $updateSql = "UPDATE volunteer_activities SET signup_num = signup_num + 1 WHERE id = :id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([':id' => $activityId]);

        echo "<script>alert('报名成功！我们会尽快联系您，请保持电话畅通。'); window.location.href='activity.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('报名失败：" . $e->getMessage() . "'); window.history.back();</script>";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>志愿报名 - <?php echo htmlspecialchars($activity['activity_name']); ?></title>
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

        .container {
            max-width: 600px;
            margin: 4rem auto;
            padding: 0 1.5rem;
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.5s ease-out;
        }

        .card-header {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2.5L25 20l-5 4.5V22h20v2H20v2.5L15 20l5-4.5V18H0v2h20v2.5z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .card-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.9);
            position: relative;
        }

        .activity-info {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 1.5rem;
            margin: 0 1.5rem -1rem;
            border-radius: 1rem;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.15);
        }

        .activity-info h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #166534;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(34, 197, 94, 0.2);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.625rem 0;
            border-bottom: 1px solid rgba(34, 197, 94, 0.1);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 2.5rem 1.5rem 2rem;
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-title svg {
            width: 20px;
            height: 20px;
            color: #22c55e;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-label .required {
            color: #ef4444;
            font-size: 0.75rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #fafafa;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
            background: white;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-hint {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-hint svg {
            width: 14px;
            height: 14px;
            color: #f59e0b;
        }

        .btn-submit {
            width: 100%;
            padding: 1.125rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 18px rgba(34, 197, 94, 0.4);
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(34, 197, 94, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 0;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #22c55e;
        }

        .back-link svg {
            width: 18px;
            height: 18px;
        }

        .success-message {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .success-message svg {
            width: 24px;
            height: 24px;
            color: #16a34a;
            flex-shrink: 0;
        }

        .success-message p {
            color: #166534;
            font-size: 0.9rem;
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

        @media (max-width: 640px) {
            .navbar .container {
                padding: 1rem;
            }

            .navbar-links {
                gap: 1rem;
            }

            .container {
                padding: 0 1rem;
                margin: 2rem auto;
            }

            .card {
                border-radius: 1rem;
            }

            .card-header {
                padding: 1.5rem;
            }

            .card-header h1 {
                font-size: 1.5rem;
            }

            .activity-info {
                margin: 0 1rem -1rem;
                padding: 1.25rem;
            }

            .card-body {
                padding: 2rem 1rem 1.5rem;
            }

            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .info-value {
                font-weight: 500;
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
                <a href="suggest.php">意见反馈</a>
                <a href="admin_login.php">后台管理</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <a href="activity.php" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 19l-7-7 7-7"/>
            </svg>
            返回活动列表
        </a>

        <div class="card">
            <div class="card-header">
                <h1>报名：<?php echo htmlspecialchars($activity['activity_name']); ?></h1>
                <p>填写信息完成志愿活动报名</p>
            </div>

            <div class="activity-info">
                <h3>活动信息</h3>
                <div class="info-row">
                    <span class="info-label">活动时间</span>
                    <span class="info-value"><?php echo date('Y-m-d H:i', strtotime($activity['activity_time'])); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">活动地点</span>
                    <span class="info-value"><?php echo htmlspecialchars($activity['activity_address']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">剩余名额</span>
                    <span class="info-value" style="color: #22c55e;"><?php echo $activity['max_num'] - $activity['signup_num']; ?> / <?php echo $activity['max_num']; ?> 人</span>
                </div>
            </div>

            <div class="card-body">
                <h2 class="form-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    个人信息
                </h2>

                <form method="post" id="signup-form">
                    <div class="form-group">
                        <label class="form-label">
                            姓名 <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" id="username" name="username" required placeholder="请输入您的真实姓名">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            联系电话 <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-input" id="phone" name="phone" required placeholder="请输入您的手机号" pattern="[0-9]{11}" title="请输入11位手机号">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            身份证号
                        </label>
                        <input type="text" class="form-input" id="id_card" name="id_card" placeholder="请输入您的身份证号（用于志愿时长认证）">
                        <p class="form-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 9v2m0 4h.01"/>
                                <path d="M12 17h.01"/>
                                <path d="M12 20h.01"/>
                                <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                            </svg>
                            温馨提示：身份证号仅用于志愿活动备案，我们会严格保密
                        </p>
                    </div>

                    <button type="submit" class="btn-submit">确认报名</button>
                </form>
            </div>
        </div>
    </div>

    <footer style="background: #1f2937; padding: 2.5rem 2rem; margin-top: 4rem;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <p style="color: #9ca3af; font-size: 0.875rem;">© 2026 社区环保志愿平台 版权所有</p>
        </div>
    </footer>

    <script>
        document.getElementById('signup-form').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            if (phone.length !== 11 || !/^1[3-9]\d{9}$/.test(phone)) {
                e.preventDefault();
                alert('请输入有效的11位手机号');
                return false;
            }
            
            const idCard = document.getElementById('id_card').value;
            if (idCard && idCard.length !== 18) {
                e.preventDefault();
                alert('身份证号必须为18位');
                return false;
            }
        });
    </script>
</body>
</html>