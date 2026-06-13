<?php
// 数据库配置
$db_host = '127.0.0.1';
$db_name = 'env_protect'; // 你的数据库名
$db_user = 'root';        // 你的数据库用户名
$db_pass = '';            // 你的数据库密码（默认空）

try {
    // 创建PDO连接
    $pdo = new PDO(
        "mysql:host=$db_host;port=3308;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // 开启错误异常模式
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // 默认返回关联数组
        ]
    );
} catch(PDOException $e) {
    die("数据库连接失败：" . $e->getMessage());
}
?>