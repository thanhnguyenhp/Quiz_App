<?php
include '../config/db.php';

// Xóa toàn bộ dữ liệu trong bảng exam_results
$conn->query("DELETE FROM exam_results");

// Chuyển hướng về trang view_results.php
header('Location: view_results.php');
exit;
?>