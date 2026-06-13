<?php
// 简单登录验证（实际项目需加密，此处简化）
$admin_user = $_POST['admin_user'] ?? '';
$admin_pwd = $_POST['admin_pwd'] ?? '';
if ($admin_user !== 'admin' || $admin_pwd !== '123456') {
    echo "<script>alert('账号或密码错误！'); window.location.href='admin_login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台管理 - 环保网站</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: "微软雅黑", sans-serif;
    /* 后台背景：更沉稳的绿色系 */
    background: linear-gradient(135deg, #f5f7f9 0%, #e9f0e9 100%);
    background-image: 
        radial-gradient(rgba(39, 174, 96, 0.03) 2px, transparent 2px),
        radial-gradient(rgba(39, 174, 96, 0.03) 2px, transparent 2px);
    background-size: 50px 50px;
    background-position: 0 0, 25px 25px;
    min-height: 100vh;
}
header { 
    background: linear-gradient(120deg, #27ae60 0%, #219653 100%);
    color: white; 
    padding: 15px 20px; 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.2);
}
.admin-nav { 
    width: 200px; 
    background: rgba(255, 255, 255, 0.95);
    height: calc(100vh - 62px); 
    float: left; 
    box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    border-right: 1px solid #e8f5e9;
}
.nav-item { 
    padding: 15px 20px; 
    border-bottom: 1px solid #f1f7f1; 
    cursor: pointer; 
    transition: all 0.2s ease;
}
.nav-item a { color: #333; text-decoration: none; display: block; }
.nav-item:hover { 
    background: #e8f5e9;
    padding-left: 25px; /* 悬浮缩进，更有交互感 */
}
.content { margin-left: 200px; padding: 20px; }
.card { 
    background: rgba(255, 255, 255, 0.95);
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e8f5e9;
}
h2 { 
    color: #27ae60; 
    margin-bottom: 15px; 
    border-bottom: 2px solid #e8f5e9;
    padding-bottom: 8px;
}
.btn { 
    display: inline-block; 
    padding: 8px 15px; 
    background: linear-gradient(120deg, #27ae60 0%, #2ecc71 100%);
    color: white; 
    text-decoration: none; 
    border-radius: 4px; 
    margin-bottom: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn:hover {
    background: linear-gradient(120deg, #219653 0%, #27ae60 100%);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
}
.btn-danger { 
    background: linear-gradient(120deg, #e74c3c 0%, #c0392b 100%);
}
.btn-danger:hover {
    background: linear-gradient(120deg, #c0392b 0%, #a93226 100%);
    box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
}

/* 表格样式优化 */
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e8f5e9; }
th { 
    background: #e8f5e9; 
    color: #2c3e50; 
    font-weight: bold;
}
tr:hover {
    background: #f9fcf9; /* 行悬浮高亮 */
}

/* 表单元素优化 */
.form-inline { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; }
.form-group { margin-right: 15px; }
label { display: block; margin-bottom: 5px; font-weight: bold; color: #666; }
input, textarea, select { 
    padding: 8px; 
    border: 1px solid #e8f5e9; 
    border-radius: 4px; 
    width: 200px;
    transition: border 0.3s ease;
}
input:focus, textarea:focus, select:focus {
    border-color: #27ae60;
    outline: none;
    box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.1);
}
textarea { width: 300px; height: 80px; resize: none; }
button { 
    padding: 8px 15px; 
    background: linear-gradient(120deg, #27ae60 0%, #2ecc71 100%);
    color: white; 
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    margin-top: 22px;
    transition: all 0.3s ease;
}
button:hover {
    background: linear-gradient(120deg, #219653 0%, #27ae60 100%);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
}
    </style>
</head>
<body>
   <header>
    <h1>环保网站后台管理</h1>
    <!-- 新增这一行 -->
    <a href="../index.php" class="btn" style="background:#3498db;">查看前台网站</a> 
    <a href="admin_login.php?logout=1" class="btn btn-danger">退出登录</a>
</header>

    <div class="admin-nav">
        <div class="nav-item"><a href="admin_images.php">图片管理</a></div>
        <div class="nav-item"><a href="admin_suggestions.php">意见管理</a></div>
    </div>

    <div class="content">
        <div class="card">
            <h2>欢迎进入后台管理系统</h2>
            <p>请选择左侧菜单进行数据管理操作</p>
        </div>
    </div>
</body>
</html>