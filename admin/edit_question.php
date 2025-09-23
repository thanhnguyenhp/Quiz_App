<?php
include '../config/db.php';
$id = $_GET['id'];
$exam_id = $_GET['exam_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];

    $conn->query("UPDATE questions SET 
                    question_text='$question_text', 
                    option_a='$option_a',
                    option_b='$option_b',
                    option_c='$option_c',
                    option_d='$option_d',
                    correct_answer='$correct_answer'
                  WHERE id=$id");

    header("Location: list_questions.php?exam_id=$exam_id");
}

$question = $conn->query("SELECT * FROM questions WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa câu hỏi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f4f6fb, #eaf6ff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .form-container h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            text-transform: uppercase;
        }

        .form-container label {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            display: block;
            margin-bottom: 8px;
        }

        .form-container textarea,
        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-container textarea {
            resize: none; /* Vô hiệu hóa thay đổi kích thước */
        }

        .form-container button {
            display: block;
            width: 100%;
            background: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .form-container button:hover {
            background: #2980b9;
            transform: scale(1.05);
        }

        .form-container a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .form-container a:hover {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Sửa câu hỏi</h2>
    <form method="POST">
        <label for="question_text">Nội dung câu hỏi:</label>
        <textarea id="question_text" name="question_text" rows="4" required><?= htmlspecialchars($question['question_text']) ?></textarea>

        <label for="option_a">Đáp án A:</label>
        <input id="option_a" type="text" name="option_a" value="<?= $question['option_a'] ?>" required>

        <label for="option_b">Đáp án B:</label>
        <input id="option_b" type="text" name="option_b" value="<?= $question['option_b'] ?>" required>

        <label for="option_c">Đáp án C:</label>
        <input id="option_c" type="text" name="option_c" value="<?= $question['option_c'] ?>" required>

        <label for="option_d">Đáp án D:</label>
        <input id="option_d" type="text" name="option_d" value="<?= $question['option_d'] ?>" required>

        <label for="correct_answer">Đáp án đúng (A/B/C/D):</label>
        <input id="correct_answer" type="text" name="correct_answer" value="<?= $question['correct_answer'] ?>" maxlength="1" required>

        <button type="submit">Cập nhật câu hỏi</button>
    </form>
    <a href="list_questions.php?exam_id=<?= $exam_id ?>">← Quay lại</a>
</div>

</body>
</html>
