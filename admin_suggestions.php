<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

if (isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    try {
        $sql = "UPDATE `env_suggestions` SET `status` = :status WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        header('Location: admin_suggestions.php');
        exit;
    } catch (PDOException $e) {
        die("更新失败：" . $e->getMessage());
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $sql = "DELETE FROM `env_suggestions` WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header('Location: admin_suggestions.php');
        exit;
    } catch (PDOException $e) {
        die("删除失败：" . $e->getMessage());
    }
}

try {
    $sql = "SELECT * FROM `env_suggestions` ORDER BY `submit_time` DESC";
    $stmt = $pdo->query($sql);
    $suggestions = $stmt->fetchAll();
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
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                环保意见管理
            </h2>
            <a href="suggest.php" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                查看前台
            </a>
        </div>

        <?php if (empty($suggestions)): ?>
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <h3>暂无意见反馈</h3>
                <p>用户可以在前台提交环保意见</p>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 1.25rem;">
                <?php foreach ($suggestions as $suggestion): ?>
                <div style="background: #fafafa; border-radius: 0.75rem; padding: 1.5rem; border: 1px solid #e2e8f0; transition: all 0.3s ease;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.1rem;">
                                <?php echo mb_substr($suggestion['username'], 0, 1); ?>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($suggestion['username']); ?></h4>
                                <p style="font-size: 0.85rem; color: #94a3b8;"><?php echo date('Y-m-d H:i', strtotime($suggestion['submit_time'])); ?></p>
                            </div>
                        </div>
                        <span class="badge <?php 
                            if ($suggestion['status'] == 1) {
                                echo 'badge-success';
                            } elseif ($suggestion['status'] == 2) {
                                echo 'badge-warning';
                            } else {
                                echo 'badge-danger';
                            }
                        ?>">
                            <?php 
                                if ($suggestion['status'] == 1) {
                                    echo '已采纳';
                                } elseif ($suggestion['status'] == 2) {
                                    echo '处理中';
                                } else {
                                    echo '待审核';
                                }
                            ?>
                        </span>
                    </div>
                    <p style="color: #475569; line-height: 1.75; margin-bottom: 1rem; padding: 1rem; background: white; border-radius: 0.5rem; border-left: 4px solid #22c55e;">
                        <?php echo htmlspecialchars($suggestion['content']); ?>
                    </p>
                    <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                        <?php if ($suggestion['status'] != 1): ?>
                            <a href="admin_suggestions.php?id=<?php echo $suggestion['id']; ?>&status=1" class="btn btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                采纳意见
                            </a>
                        <?php endif; ?>
                        <?php if ($suggestion['status'] != 2): ?>
                            <a href="admin_suggestions.php?id=<?php echo $suggestion['id']; ?>&status=2" class="btn btn-sm btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                                    <path d="M3 3v5h5"/>
                                    <path d="M3 16a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                                    <path d="M16 21h5v-5"/>
                                </svg>
                                处理中
                            </a>
                        <?php endif; ?>
                        <a href="admin_suggestions.php?delete=<?php echo $suggestion['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除该意见吗？')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18"/>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                            删除
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>