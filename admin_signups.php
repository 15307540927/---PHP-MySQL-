<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require 'conn.php';
$activityId = intval($_GET['activity_id'] ?? 0);

// 处理删除报名记录
if (isset($_GET['del_signup_id'])) {
    $delId = intval($_GET['del_signup_id']);
    
    try {
        // 获取关联的活动ID
        $sql = "SELECT activity_id FROM volunteer_signups WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $delId]);
        $signup = $stmt->fetch(PDO::FETCH_ASSOC);
        $activityId = $signup['activity_id'];

        // 删除报名记录
        $delSql = "DELETE FROM volunteer_signups WHERE id = :id";
        $stmt = $pdo->prepare($delSql);
        $stmt->execute([':id' => $delId]);

        // 更新活动报名人数
        $updateSql = "UPDATE volunteer_activities SET signup_num = signup_num - 1 WHERE id = :activity_id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([':activity_id' => $activityId]);

        echo "<script>alert('报名记录删除成功！'); window.location.href='admin_signups.php?activity_id=$activityId';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('删除失败：" . $e->getMessage() . "'); window.history.back();</script>";
    }
    exit;
}

// 查询活动名称
$activityName = '';
$signups = [];
if ($activityId > 0) {
    try {
        // 查询活动名称
        $activitySql = "SELECT activity_name FROM volunteer_activities WHERE id = :id";
        $stmt = $pdo->prepare($activitySql);
        $stmt->execute([':id' => $activityId]);
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
        $activityName = $activity['activity_name'];

        // 查询该活动的报名记录
        $signupSql = "SELECT * FROM volunteer_signups WHERE activity_id = :activity_id ORDER BY signup_time DESC";
        $stmt = $pdo->prepare($signupSql);
        $stmt->execute([':activity_id' => $activityId]);
        $signups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("查询失败：" . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>报名记录 - <?php echo $activityName; ?></title>
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
        <h1>报名记录管理</h1>
    </header>
    <div class="content">
        <div class="card">
            <a href="admin_activities.php" class="btn">返回活动管理</a>
            <h2>活动：<?php echo $activityName; ?> - 报名记录</h2>
            
            <table>
                <tr>
                    <th>ID</th>
                    <th>报名人姓名</th>
                    <th>联系电话</th>
                    <th>身份证号</th>
                    <th>报名时间</th>
                    <th>操作</th>
                </tr>
                <?php
                if ($activityId > 0 && count($signups) > 0) {
                    foreach ($signups as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>' . ($row['id_card'] ? htmlspecialchars($row['id_card']) : '未填写') . '</td>';
                        echo '<td>' . $row['signup_time'] . '</td>';
                        echo '<td><a href="admin_signups.php?activity_id=' . $activityId . '&del_signup_id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'确定删除该报名记录？\')">删除</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" style="text-align:center; color:#999;">暂无报名记录</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>