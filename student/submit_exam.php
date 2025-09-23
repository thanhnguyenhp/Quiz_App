<?php
session_start();
include '../config/db.php';

$answers = $_POST['answers'] ?? [];
$exam_id = $_POST['exam_id'];
$student_name = $_SESSION['name'] ?? 'Guest'; // Lấy tên từ session nếu có

$score = 0;
$total = count($answers);

// Đếm số câu đúng
foreach ($answers as $question_id => $selected) {
    $res = $conn->query("SELECT correct_answer FROM questions WHERE id = $question_id");
    $row = $res->fetch_assoc();
    if (strtoupper($selected) == strtoupper($row['correct_answer'])) {
        $score++;
    }
}

// Tính điểm trên thang 10
$final_score = round(($score / $total) * 10, 2);

// Lưu kết quả vào DB
$conn->query("INSERT INTO exam_results (exam_id, student_name, total_questions, correct_answers)
              VALUES ('$exam_id', '$student_name', '$total', '$score')");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả bài thi</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .result-box {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .result-box h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .result-box p {
            font-size: 18px;
            margin: 10px 0;
        }

        .result-box strong {
            color: #e74c3c;
        }

        .result-box a {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .result-box a:hover {
            background: #2980b9;
        }

        .details-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
        }

        .details-box h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .details-box ul {
            list-style: none;
            padding: 0;
        }

        .details-box li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .correct {
            color: #27ae60;
        }

        .incorrect {
            color: #e74c3c;
        }
    </style>
</head>
<body>

    <div class="result-box">
        <h2>✅ Kết quả bài thi</h2>
        <p>👤 Họ tên: <strong><?= htmlspecialchars($student_name) ?></strong></p>
        <p>Bạn đã trả lời đúng <strong><?= $score ?> / <?= $total ?></strong> câu.</p>
        <p>🎯 Điểm số: <strong><?= $final_score ?> / 10</strong></p>
        <a href="../Login/login.php">🚪 Thoát</a>
    </div>

    <div class="details-box">
        <h3>Chi tiết câu trả lời</h3>
        <ul>
            <?php
            foreach ($answers as $question_id => $selected) {
                $res = $conn->query("SELECT question_text, correct_answer, option_a, option_b, option_c, option_d FROM questions WHERE id = $question_id");
                $row = $res->fetch_assoc();
                $is_correct = strtoupper($selected) == strtoupper($row['correct_answer']);
                ?>
                <li class="<?= $is_correct ? 'correct' : 'incorrect' ?>">
                    <strong>Câu hỏi:</strong> <?= htmlspecialchars($row['question_text']) ?><br>
                    <strong>Đáp án của bạn:</strong> <?= htmlspecialchars($row['option_' . strtolower($selected)]) ?><br>
                    <strong>Đáp án đúng:</strong> <?= htmlspecialchars($row['option_' . strtolower($row['correct_answer'])]) ?>
                </li>
            <?php } ?>
        </ul>
    </div>

</body>
</html>
