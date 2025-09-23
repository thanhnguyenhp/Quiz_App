<?php
include '../config/db.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $conn->query("UPDATE exams SET title='$title' WHERE id=$id");
    header('Location: list_exams.php');
}

$result = $conn->query("SELECT * FROM exams WHERE id=$id");
$row = $result->fetch_assoc();
?>

<h2>Sửa bài thi</h2>
<form method="POST">
    <label>Tiêu đề:</label><br>
    <input type="text" name="title" value="<?= $row['title'] ?>" required><br><br>
    <button type="submit">Cập nhật</button>
</form>
