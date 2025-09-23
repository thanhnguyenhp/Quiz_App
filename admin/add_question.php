<?php
include '../config/db.php';
$exam_id = $_GET['exam_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];

    $conn->query("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer)
                  VALUES ('$exam_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_answer')");

    header("Location: list_questions.php?exam_id=$exam_id");
}
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
form {
    width: 60%;
    margin: 30px auto;
    background: #fff;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
form label {
    font-size: 16px;
    font-weight: bold;
    color: #2d3a4b;
    display: block;
    margin-bottom: 8px;
}
form textarea, form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}
form textarea {
    resize: none;
    height: 100px;
}
form button {
    display: block;
    width: 100%;
    background: #3498db;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
form button:hover {
    background: #2980b9;
    transform: scale(1.05);
}
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
    font-weight: bold;
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s;
}
a:hover {
    color: #2d3a4b;
}
</style>

<h2>Thêm câu hỏi mới</h2>

<form method="POST">
    <label for="question_text">Nội dung câu hỏi:</label>
    <textarea id="question_text" name="question_text" required></textarea>

    <label for="option_a">Đáp án A:</label>
    <input id="option_a" type="text" name="option_a" required>

    <label for="option_b">Đáp án B:</label>
    <input id="option_b" type="text" name="option_b" required>

    <label for="option_c">Đáp án C:</label>
    <input id="option_c" type="text" name="option_c" required>

    <label for="option_d">Đáp án D:</label>
    <input id="option_d" type="text" name="option_d" required>

    <label for="correct_answer">Đáp án đúng (A/B/C/D):</label>
    <input id="correct_answer" type="text" name="correct_answer" maxlength="1" required>

    <button type="submit">Thêm câu hỏi</button>
</form>

<a href="list_questions.php?exam_id=<?= $exam_id ?>">← Quay lại</a>