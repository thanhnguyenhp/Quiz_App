<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM exams");
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f4f6fb, #eaf6ff);
    margin: 0;
    padding: 0;
}
h2 {
    color: #2d3a4b;
    text-align: center;
    margin-top: 30px;
    font-size: 28px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
a {
    color: #3498db;
    text-decoration: none;
    margin: 0 5px;
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
}
table {
    margin: 30px auto;
    border-collapse: collapse;
    width: 90%;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
th, td {
    padding: 14px 20px;
    text-align: center;
    font-size: 16px;
}
th {
    background: #3498db;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
}
tr:nth-child(even) {
    background: #f2f8fc;
}
tr:hover {
    background: #eaf6ff;
    cursor: pointer;
    transition: background 0.3s;
}
.add-btn {
    display: inline-block;
    background: #27ae60;
    color: #fff !important;
    padding: 10px 20px;
    border-radius: 5px;
    margin: 20px auto 10px 10%;
    font-weight: bold;
    font-size: 16px;
    transition: background 0.3s, transform 0.2s;
    text-align: center;
    text-decoration: none;
}
.add-btn:hover {
    background: #219150;
    transform: scale(1.05);
}
.action-links a {
    margin: 0 6px;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    transition: background 0.3s, transform 0.2s;
    text-decoration: none;
}
.action-links a:nth-child(1) { background: #f1c40f; color: #fff; }
.action-links a:nth-child(1):hover { background: #d4ac0d; transform: scale(1.1); }
.action-links a:nth-child(2) { background: #e74c3c; color: #fff; }
.action-links a:nth-child(2):hover { background: #c0392b; transform: scale(1.1); }
.action-links a:nth-child(3) { background: #2980b9; color: #fff; }
.action-links a:nth-child(3):hover { background: #1c5d8c; transform: scale(1.1); }
.top-links {
    display: flex;
    justify-content: flex-end;
    margin: 0 10% 20px 0;
}
.top-links a {
    margin-left: 20px;
    font-size: 18px;
    font-weight: bold;
    color: #2d3a4b;
    text-decoration: none;
    transition: color 0.3s;
}
.top-links a:hover {
    color: #3498db;
}
</style>

<h2>Danh sách bài thi</h2>
<a href="add_exam.php" class="add-btn">+ Thêm bài thi</a><br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Hành động</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td class="action-links">
            <a href="edit_exam.php?id=<?= $row['id'] ?>">Sửa</a>
            <a href="delete_exam.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            <a href="list_questions.php?exam_id=<?= $row['id'] ?>">Quản lý câu hỏi</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<div class="top-links">
    <a href="../Login/loginAdmin.php">🚪 Thoát</a>
    <a href="view_results.php">📊 Xem kết quả sinh viên</a>
</div>

