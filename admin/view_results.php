<?php
include '../config/db.php';

$query = "
SELECT 
    u.id AS 'Mã SV',
    u.name AS 'Tên SV',
    u.class AS 'Lớp',
    e.title AS 'Môn thi',
    ROUND((r.correct_answers / r.total_questions) * 100, 2) AS 'Kết quả',
    ROUND((r.correct_answers / r.total_questions) * 10, 1) AS 'Điểm'
FROM 
    exam_results r
JOIN 
    users u ON r.student_name = u.name
JOIN 
    exams e ON r.exam_id = e.id
ORDER BY 
    u.class, u.name
";

$result = $conn->query($query);
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
    display: inline-block;
    margin: 20px auto;
    font-size: 16px;
    font-weight: bold;
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s;
}
a:hover {
    color: #2d3a4b;
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
form {
    text-align: center;
    margin-top: 20px;
}
form button {
    background: #27ae60;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
form button:hover {
    background: #219150;
    transform: scale(1.05);
}
.delete-btn {
    background: #e74c3c;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    margin-top: 10px;
}
.delete-btn:hover {
    background: #c0392b;
    transform: scale(1.05);
}
.back-btn {
    display: inline-block;
    margin: 20px auto;
    padding: 12px 20px;
    background: #3498db;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    border-radius: 6px;
    transition: background 0.3s, transform 0.2s;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.back-btn:hover {
    background: #2980b9;
    transform: scale(1.05);
}
</style>

<h2>Kết quả bài thi của sinh viên</h2>
<a href="list_exams.php" class="back-btn">🔙 Quay lại</a>

<table>
    <tr>
        <th>Mã SV</th>
        <th>Tên sinh viên</th>
        <th>Lớp</th>
        <th>Môn thi</th>
        <th>Kết quả</th>
        <th>Điểm</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Mã SV']) ?></td>
                <td><?= htmlspecialchars($row['Tên SV']) ?></td>
                <td><?= htmlspecialchars($row['Lớp']) ?></td>
                <td><?= htmlspecialchars($row['Môn thi']) ?></td>
                <td><?= htmlspecialchars($row['Kết quả']) ?>%</td>
                <td><?= htmlspecialchars($row['Điểm']) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">Không có kết quả nào.</td></tr>
    <?php endif; ?>
</table>

<form action="delete_results.php" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ bảng điểm?')">
    <button type="submit" class="delete-btn">🗑️ Xóa bảng điểm</button>
</form>

<form action="export_word.php" method="post">
    <button type="submit">🖨️ In bảng điểm</button>
</form>
