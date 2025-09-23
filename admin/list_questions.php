<?php
include '../config/db.php';

$exam_id = $_GET['exam_id'];
$exam = $conn->query("SELECT * FROM exams WHERE id=$exam_id")->fetch_assoc();
$questions = $conn->query("SELECT * FROM questions WHERE exam_id=$exam_id");
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
.action-links {
    display: flex;
    justify-content: center;
    gap: 10px; 
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
.add-btn, .back-btn, .import-btn {
    display: inline-block;
    background: #27ae60;
    color: #fff !important;
    padding: 10px 20px;
    border-radius: 5px;
    margin: 20px 10px;
    font-weight: bold;
    font-size: 16px;
    transition: background 0.3s, transform 0.2s;
    text-align: center;
    text-decoration: none;
}
.add-btn:hover, .back-btn:hover, .import-btn:hover {
    background: #219150;
    transform: scale(1.05);
}
</style>

<h2>Danh sách câu hỏi cho bài thi: <?= $exam['title'] ?></h2>

<div style="text-align: center;">
    <a href="add_question.php?exam_id=<?= $exam_id ?>" class="add-btn">+ Thêm câu hỏi</a>
    <a href="list_exams.php" class="back-btn">← Quay lại danh sách bài thi</a>
    <a href="import_questions.php?exam_id=<?= $exam_id ?>" class="import-btn">📥 Import câu hỏi</a>
</div>

<table>
    <tr>
        <th>Nội dung</th>
        <th>Đáp án A</th>
        <th>Đáp án B</th>
        <th>Đáp án C</th>
        <th>Đáp án D</th>
        <th>Đáp án đúng</th>
        <th>Hành động</th>
    </tr>

    <?php while($row = $questions->fetch_assoc()): ?>
    <tr>
        <td><?= $row['question_text'] ?></td>
        <td><?= $row['option_a'] ?></td>
        <td><?= $row['option_b'] ?></td>
        <td><?= $row['option_c'] ?></td>
        <td><?= $row['option_d'] ?></td>
        <td><?= $row['correct_answer'] ?></td>
        <td class="action-links">
            <a href="edit_question.php?id=<?= $row['id'] ?>&exam_id=<?= $exam_id ?>">Sửa</a>
            <a href="delete_question.php?id=<?= $row['id'] ?>&exam_id=<?= $exam_id ?>" onclick="return confirm('Bạn chắc chắn muốn xóa câu hỏi này?')">Xóa</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
