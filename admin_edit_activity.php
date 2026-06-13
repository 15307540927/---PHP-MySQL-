<?php
session_start();
// 检查是否已登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// 引入PDO数据库连接
require 'conn.php';

// 获取活动ID
$activityId = intval($_GET['id'] ?? 0);
if ($activityId === 0) {
    echo "<script>alert('无效的活动ID！');window.location.href='admin_activities.php';</script>";
    exit;
}

// 查询活动信息
try {
    $sql = "SELECT * FROM volunteer_activities WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $activityId]);
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("查询活动失败：" . $e->getMessage());
}

if (!$activity) {
    echo "<script>alert('该活动不存在！');window.location.href='admin_activities.php';</script>";
    exit;
}

// 处理修改提交
if (isset($_POST['edit_activity'])) {
    $activityName = trim($_POST['activity_name'] ?? '');
    $activityDesc = trim($_POST['activity_desc'] ?? '');
    $activityTime = trim($_POST['activity_time'] ?? '');
    $activityAddress = trim($_POST['activity_address'] ?? '');
    $maxNum = intval($_POST['max_num'] ?? 0);

    // 基础校验
    if (empty($activityName) || empty($activityTime) || $maxNum <= 0) {
        echo "<script>alert('活动名称、时间、最大报名人数不能为空或无效！');window.history.back();</script>";
        exit;
    }

    try {
        // PDO预处理更新语句
        $updateSql = "UPDATE volunteer_activities 
                      SET activity_name = :name,
                          activity_desc = :desc,
                          activity_time = :time,
                          activity_address = :address,
                          max_num = :max_num
                      WHERE id = :id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([
            ':name' => $activityName,
            ':desc' => $activityDesc,
            ':time' => $activityTime,
            ':address' => $activityAddress,
            ':max_num' => $maxNum,
            ':id' => $activityId
        ]);

        echo "<script>alert('活动修改成功！');window.location.href='admin_activities.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('修改失败：" . $e->getMessage() . "');window.history.back();</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>修改活动 - 后台</title>
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
        <h1>修改志愿活动</h1>
    </header>
    <div class="content">
        <div class="card">
            <form method="post">
                <div class="form-group">
                    <label>活动名称</label>
                    <input type="text" name="activity_name" value="<?php echo $activity['activity_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>活动时间</label>
                    <input type="datetime-local" name="activity_time" value="<?php echo date('Y-m-d\TH:i', strtotime($activity['activity_time'])); ?>" required>
                </div>
                <div class="form-group">
                    <label>活动地点</label>
                    <input type="text" name="activity_address" value="<?php echo $activity['activity_address']; ?>" required>
                </div>
                <div class="form-group">
                    <label>最大报名人数</label>
                    <input type="number" name="max_num" value="<?php echo $activity['max_num']; ?>" required min="1">
                </div>
                <div class="form-group">
                    <label>活动描述</label>
                    <textarea name="activity_desc" required><?php echo $activity['activity_desc']; ?></textarea>
                </div>
                <button type="submit" name="edit_activity" class="btn">保存修改</button>
                <a href="admin_activities.php" class="btn btn-cancel">取消</a>
            </form>
        </div>
    </div>
</body>
</html>