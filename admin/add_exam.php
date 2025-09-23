<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $conn->query("INSERT INTO exams (title) VALUES ('$title')");
    header('Location: list_exams.php');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài thi</title>
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
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-container h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
            text-transform: uppercase;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-container button {
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
    <h2>Thêm bài thi</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Nhập tiêu đề bài thi" required>
        <button type="submit">Thêm</button>
    </form>
    <a href="list_exams.php">← Quay lại danh sách bài thi</a>
</div>

</body>
</html>
