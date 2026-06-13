<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $quota = (int)($_POST['quota'] ?? 0);
    $datetime = $_POST['datetime'] ?? '';
    $id = $_POST['id'] ?? '';

    if (empty($title) || empty($description) || empty($location) || $quota <= 0 || empty($datetime)) {
        echo "<script>alert('请填写完整信息！');history.back();</script>";
        exit;
    }

    try {
        if (!empty($id)) {
            $sql = "UPDATE `volunteer_activities` SET `activity_name` = :title, `activity_desc` = :description, `activity_address` = :location, `max_num` = :quota, `activity_time` = :datetime WHERE `id` = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
        } else {
            $sql = "INSERT INTO `volunteer_activities` (`activity_name`, `activity_desc`, `activity_address`, `max_num`, `activity_time`) VALUES (:title, :description, :location, :quota, :datetime)";
            $stmt = $pdo->prepare($sql);
        }
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':quota', $quota);
        $stmt->bindParam(':datetime', $datetime);
        
        if ($stmt->execute()) {
            header('Location: admin_activities.php');
            exit;
        }
    } catch (PDOException $e) {
        die("数据库操作失败：" . $e->getMessage());
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $sql = "DELETE FROM `volunteer_activities` WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header('Location: admin_activities.php');
        exit;
    } catch (PDOException $e) {
        die("删除失败：" . $e->getMessage());
    }
}

$edit_activity = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    try {
        $sql = "SELECT * FROM `volunteer_activities` WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $edit_activity = $stmt->fetch();
    } catch (PDOException $e) {
        die("查询失败：" . $e->getMessage());
    }
}

try {
    $sql = "SELECT * FROM `volunteer_activities` ORDER BY `activity_time` DESC";
    $stmt = $pdo->query($sql);
    $activities = $stmt->fetchAll();
} catch (PDOException $e) {
    die("查询失败：" . $e->getMessage());
}
?>
<?php include 'admin_header.php'; ?>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                志愿活动管理
            </h2>
            <button class="btn" onclick="document.getElementById('activityForm').scrollIntoView({behavior:'smooth'})">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 4v16"/>
                    <path d="M4 12h16"/>
                </svg>
                添加活动
            </button>
        </div>

        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600; color: #374151;">活动列表</h3>
            <?php if (empty($activities)): ?>
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    <h3>暂无活动</h3>
                    <p>点击上方按钮添加第一个活动</p>
                </div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>活动名称</th>
                            <th>时间</th>
                            <th>地点</th>
                            <th>名额</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activities as $activity): ?>
                        <tr>
                            <td><strong style="color: #1e293b;"><?php echo htmlspecialchars($activity['activity_name']); ?></strong></td>
                            <td style="color: #64748b;"><?php echo date('Y-m-d H:i', strtotime($activity['activity_time'])); ?></td>
                            <td style="color: #64748b;"><?php echo htmlspecialchars($activity['activity_address']); ?></td>
                            <td>
                                <?php 
                                $signup_count = 0;
                                try {
                                    $sql = "SELECT COUNT(*) FROM `volunteer_signups` WHERE `activity_id` = :id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':id', $activity['id']);
                                    $stmt->execute();
                                    $signup_count = $stmt->fetchColumn();
                                } catch (PDOException $e) {}
                                ?>
                                <span class="badge <?php echo $signup_count >= $activity['max_num'] ? 'badge-warning' : 'badge-success'; ?>">
                                    <?php echo $signup_count; ?>/<?php echo $activity['max_num']; ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="admin_activities.php?edit=<?php echo $activity['id']; ?>" class="btn btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                        </svg>
                                        编辑
                                    </a>
                                    <a href="admin_signups.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        报名列表
                                    </a>
                                    <a href="admin_activities.php?delete=<?php echo $activity['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除该活动吗？')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                        删除
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div id="activityForm" style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #f1f5f9;">
            <h3 style="margin-bottom: 1.25rem; font-size: 1.1rem; font-weight: 600; color: #374151;">
                <?php echo $edit_activity ? '编辑活动' : '添加活动'; ?>
            </h3>
            <form method="post" class="form-inline" style="gap: 1.5rem;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label>活动名称</label>
                    <input type="text" name="title" value="<?php echo $edit_activity ? htmlspecialchars($edit_activity['activity_name']) : ''; ?>" required placeholder="请输入活动名称">
                </div>
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label>活动地点</label>
                    <input type="text" name="location" value="<?php echo $edit_activity ? htmlspecialchars($edit_activity['activity_address']) : ''; ?>" required placeholder="请输入活动地点">
                </div>
                <div class="form-group" style="min-width: 150px;">
                    <label>活动名额</label>
                    <input type="number" name="quota" value="<?php echo $edit_activity ? $edit_activity['max_num'] : ''; ?>" required min="1" placeholder="名额">
                </div>
                <div class="form-group" style="min-width: 200px;">
                    <label>活动时间</label>
                    <input type="datetime-local" name="datetime" value="<?php echo $edit_activity ? date('Y-m-d\TH:i', strtotime($edit_activity['activity_time'])) : ''; ?>" required>
                </div>
                <div class="form-group" style="flex: 1; min-width: 300px;">
                    <label>活动描述</label>
                    <textarea name="description" required placeholder="请输入活动描述"><?php echo $edit_activity ? htmlspecialchars($edit_activity['activity_desc']) : ''; ?></textarea>
                </div>
                <?php if ($edit_activity): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_activity['id']; ?>">
                <?php endif; ?>
                <div class="form-group" style="align-self: flex-end;">
                    <button type="submit" class="btn">
                        <?php echo $edit_activity ? '保存修改' : '添加活动'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>