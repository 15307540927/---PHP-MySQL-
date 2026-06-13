<?php
session_start();
// 引入PDO数据库连接
require 'conn.php';

// 判断是否为POST提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取并过滤表单数据
    $username = trim($_POST['username'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $submit_time = date('Y-m-d H:i:s');
    $status = 0; // 默认未审核

    // 简单校验
    if (empty($username) || empty($content)) {
        echo "<script>alert('用户名和内容不能为空！');window.history.back();</script>";
        exit;
    }

    try {
        // 使用PDO预处理语句，防止SQL注入
        $sql = "INSERT INTO env_suggestions (username, content, submit_time, status) 
                VALUES (:username, :content, :submit_time, :status)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':submit_time', $submit_time);
        $stmt->bindParam(':status', $status);
        
        // 执行SQL
        if ($stmt->execute()) {
            echo "<script>alert('环保意见提交成功！');window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('提交失败，请重试！');window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('提交失败：" . $e->getMessage() . "');window.history.back();</script>";
    }
} else {
    // 非POST提交，跳回首页
    header('Location: index.php');
    exit;
}
?>