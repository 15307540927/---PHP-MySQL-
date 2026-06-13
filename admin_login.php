<?php
session_start();
require 'conn.php';

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php');
    exit;
}

if (isset($_SESSION['admin'])) {
    header('Location: admin_activities.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_user = $_POST['admin_user'] ?? '';
    $admin_pwd = $_POST['admin_pwd'] ?? '';

    if (empty($admin_user) || empty($admin_pwd)) {
        echo "<script>alert('账号和密码不能为空！');history.back();</script>";
        exit;
    }

    try {
        $sql = "SELECT * FROM `admin` WHERE `username` = :user LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user', $admin_user);
        $stmt->execute();
        $admin = $stmt->fetch();

        if ($admin && $admin['password'] === $admin_pwd) {
            $_SESSION['admin'] = $admin['username'];
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: admin_activities.php');
            exit;
        } else {
            echo "<script>alert('账号或密码错误！');window.location.href='admin_login.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        die("数据库查询失败：" . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理登录 - 社区环保志愿</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d4e9d9 100%);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.5s ease-out;
        }

        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            padding: 2.5rem 2rem;
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
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2.5L25 20l-5 4.5V22h20v2H20v2.5L15 20l5-4.5V18H0v2h20v2.5z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .logo {
            width: 72px;
            height: 72px;
            background: white;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
        }

        .logo svg {
            width: 36px;
            height: 36px;
            color: #22c55e;
        }

        .card-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 2.5rem 2rem;
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
            gap: 0.5rem;
        }

        .form-label svg {
            width: 16px;
            height: 16px;
            color: #22c55e;
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
            text-align: center;
        }

        .btn-login {
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(34, 197, 94, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login svg {
            width: 18px;
            height: 18px;
        }

        .back-link {
            display: block;
            text-align: center;
            padding: 1rem 0;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #22c55e;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .demo-credentials {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 1.25rem;
        }

        .demo-credentials h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #166534;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-credentials h4 svg {
            width: 16px;
            height: 16px;
        }

        .demo-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .demo-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0.75rem;
            background: white;
            border-radius: 6px;
        }

        .demo-label {
            color: #6b7280;
        }

        .demo-value {
            color: #22c55e;
            font-weight: 600;
            font-family: monospace;
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

        @media (max-width: 480px) {
            .login-container {
                padding: 0 0.5rem;
            }

            .login-card {
                border-radius: 1rem;
            }

            .card-header {
                padding: 2rem 1.5rem;
            }

            .card-body {
                padding: 2rem 1.5rem;
            }

            .logo {
                width: 56px;
                height: 56px;
            }

            .logo svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7.5 18H3v-3.5a2.121 2.121 0 0 1 3-3L16.5 3.5z"/>
                    </svg>
                </div>
                <h1>后台管理</h1>
                <p>社区环保志愿管理系统</p>
            </div>

            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            管理员账号
                        </label>
                        <input type="text" class="form-input" name="admin_user" required placeholder="请输入账号">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            管理员密码
                        </label>
                        <input type="password" class="form-input" name="admin_pwd" required placeholder="请输入密码">
                    </div>

                    <button type="submit" class="btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h6v6"/>
                            <path d="M9 21H3v-6"/>
                            <path d="M21 3l-7 7 7 7"/>
                            <path d="M18 15l-6-6-6 6"/>
                        </svg>
                        登录系统
                    </button>
                </form>

                <a href="index.php" class="back-link">返回前台网站</a>

                <div class="divider">演示账号</div>

                <div class="demo-credentials">
                    <h4>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 12v9"/>
                            <path d="M18 21v-6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v6"/>
                            <path d="M5.6 10.6A2 2 0 1 1 9 12"/>
                            <path d="M15 10.6a2 2 0 1 0 3.4 1.4"/>
                        </svg>
                        测试账号
                    </h4>
                    <div class="demo-info">
                        <div class="demo-row">
                            <span class="demo-label">账号：</span>
                            <span class="demo-value">admin</span>
                        </div>
                        <div class="demo-row">
                            <span class="demo-label">密码：</span>
                            <span class="demo-value">123456</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>