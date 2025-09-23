<?php
include '../config/db.php';

if (isset($_POST['import'])) {
    $exam_id = $_POST['exam_id'];
    $file = $_FILES['file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== false) {
        $rowIndex = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            // Bỏ qua dòng tiêu đề
            if ($rowIndex++ == 0) continue;

            $question_text = addslashes($data[0] ?? '');
            $option_a = addslashes($data[1] ?? '');
            $option_b = addslashes($data[2] ?? '');
            $option_c = addslashes($data[3] ?? '');
            $option_d = addslashes($data[4] ?? '');
            $option_d = addslashes($data[5] ?? '');
            $option_d = addslashes($data[6] ?? '');
            $correct_answer = strtoupper(trim($data[7] ?? ''));

            if ($question_text !== '') {
                $conn->query("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer)
                              VALUES ('$exam_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_answer')");
            }
        }
        fclose($handle);

        echo "<script>alert('Import CSV thành công!'); window.location.href='list_questions.php?exam_id=$exam_id';</script>";
    } else {
        echo "<script>alert('Không thể mở file CSV!');</script>";
    }
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
    width: 50%;
    margin: 50px auto;
    background: #fff;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
}
form label {
    font-size: 16px;
    font-weight: bold;
    color: #2d3a4b;
    display: block;
    margin-bottom: 10px;
}
form input[type="file"] {
    display: block;
    margin: 10px auto 20px auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    width: 80%;
    box-sizing: border-box;
}
form button {
    display: inline-block;
    background: #3498db;
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

<h2>Nhập câu hỏi từ CSV</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="exam_id" value="<?= htmlspecialchars($_GET['exam_id'] ?? '') ?>">
    <label for="file">Chọn file CSV:</label>
    <input id="file" type="file" name="file" accept=".csv" required>
    <button type="submit" name="import">Nhập từ CSV</button>
</form>

<a href="list_questions.php?exam_id=<?= htmlspecialchars($_GET['exam_id'] ?? '') ?>">← Quay lại danh sách câu hỏi</a>
