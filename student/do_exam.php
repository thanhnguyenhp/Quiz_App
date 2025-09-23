<?php
include '../config/db.php';

$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$questions = [];

if ($exam_id > 0) {
    $result = $conn->query("SELECT * FROM questions WHERE exam_id = $exam_id");
    if ($result && $result->num_rows > 0) {
        $questions = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "<p style='color:red;'>❌ Không tìm thấy câu hỏi nào cho bài thi này.</p>";
        exit;
    }
} else {
    echo "<p style='color:red;'>❌ Không có kỳ thi nào được chọn.</p>";
    exit;
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f4f6fb, #eaf6ff);
    margin: 0;
    padding: 20px;
}
h2 {
    text-align: center;
    color: #2d3a4b;
    font-size: 28px;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.container {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    justify-content: center;
}
.question-column {
    flex: 3;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.sidebar {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.question-block {
    display: none;
    margin-bottom: 20px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.question-block.active {
    display: block;
}
.question-block.flagged {
    border: 2px solid red;
    background-color: #ffe6e6;
}
.question-block p {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}
label {
    display: block;
    margin-bottom: 10px;
    font-size: 16px;
    color: #2d3a4b;
}
.flag-btn {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}
.flag-btn:hover {
    background: #c0392b;
}
.sidebar h4 {
    text-align: center;
    color: #3498db;
    font-size: 20px;
    margin-bottom: 15px;
}
.question-columns {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.question-column-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar li {
    margin-bottom: 5px;
}
.sidebar a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
    transition: color 0.3s;
}
.sidebar a:hover {
    color: #2d3a4b;
}
#timer {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: red;
    margin-bottom: 20px;
}
button[type="submit"] {
    display: block;
    margin: 20px auto;
    background: #27ae60;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
button[type="submit"]:hover {
    background: #219150;
    transform: scale(1.05);
}
</style>

<h2>Làm bài thi</h2>

<form action="submit_exam.php" method="post" id="examForm">
    <input type="hidden" name="exam_id" value="<?= $exam_id ?>">

    <div class="container">
        <!-- Câu hỏi bên trái -->
        <div class="question-column" id="questionContainer">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-block <?= $index === 0 ? 'active' : '' ?>" id="question<?= $index + 1 ?>">
                    <p><strong>Câu <?= $index + 1 ?>:</strong> <?= htmlspecialchars($q['question_text']) ?></p>
                    <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
                        <label>
                            <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $opt ?>">
                            <?= $opt ?>. <?= $q['option_' . strtolower($opt)] ?>
                        </label>
                    <?php endforeach; ?>
                    <button type="button" class="flag-btn" onclick="toggleFlag(<?= $index + 1 ?>)">🚩 Đánh dấu</button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sidebar bên phải -->
        <div class="sidebar">
            <h4>Danh sách câu hỏi</h4>
            <div class="question-columns">
                <?php
                $chunks = array_chunk($questions, 10);
                foreach ($chunks as $chunk):
                ?>
                    <ul class="question-column-list">
                        <?php foreach ($chunk as $q): 
                            $globalIndex = array_search($q, $questions) + 1;
                        ?>
                            <li>
                                <a href="javascript:void(0);" onclick="showQuestion(<?= $globalIndex ?>)" data-index="<?= $globalIndex ?>" id="question-link-<?= $globalIndex ?>">
                                    Câu <?= $globalIndex ?>
                                    <span id="answer-<?= $globalIndex ?>" class="answer-text"></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>

            <div id="timer"></div>
            <button type="submit">📝 Nộp bài</button>
        </div>
    </div>
</form>

<script>
// Đếm ngược 35 phút
let timeLeft = 35 * 60;
let flaggedQuestions = []; // Mảng lưu trữ các câu hỏi đã đánh dấu cờ đỏ

function startTimer() {
    const timer = document.getElementById("timer");
    const interval = setInterval(() => {
        const min = Math.floor(timeLeft / 60);
        const sec = timeLeft % 60;
        timer.textContent = `⏱️ Thời gian còn lại: ${min}:${sec < 10 ? '0' : ''}${sec}`;
        timeLeft--;
        if (timeLeft < 0) {
            clearInterval(interval);
            alert("⏰ Hết giờ! Bài thi sẽ được nộp.");
            document.getElementById("examForm").submit();
        }
    }, 1000);
}
startTimer();

document.querySelectorAll("input[type=radio]").forEach(radio => {
    radio.addEventListener("change", function() {
        const questionId = this.name.match(/\d+/)[0]; // Lấy id của câu hỏi
        const selectedAnswer = this.value; // Lấy đáp án được chọn

        // Lưu đáp án vào đối tượng answers
        answers[questionId] = selectedAnswer;

        // Cập nhật đáp án đã chọn trong sidebar
        updateSidebarAnswer(questionId, selectedAnswer);
    });
});

// Cập nhật đáp án đã chọn trong sidebar
function updateSidebarAnswer(questionId, selectedAnswer) {
    const answerText = document.getElementById('answer-' + questionId);
    const sidebarLink = document.getElementById('question-link-' + questionId);
    
    if (answerText) {
        // Hiển thị đáp án đã chọn trong sidebar
        answerText.textContent = ` (${selectedAnswer})`; 
    }
}

// Hiển thị 1 câu hỏi duy nhất khi click
function showQuestion(index) {
    const blocks = document.querySelectorAll('.question-block');
    blocks.forEach(b => b.classList.remove('active'));
    const current = document.getElementById('question' + index);
    if (current) current.classList.add('active');
}

// Kiểm tra chưa trả lời
document.getElementById("examForm").addEventListener("submit", function(e) {
    const questions = document.querySelectorAll(".question-block");
    let unanswered = 0;

    questions.forEach(q => {
        const radios = q.querySelectorAll("input[type=radio]");
        const checked = [...radios].some(r => r.checked);
        if (!checked) {
            unanswered++;
            q.style.border = "2px solid red";
        } else {
            q.style.border = "none";
        }
    });

    if (unanswered > 0) {
        e.preventDefault();
        alert(`⚠️ Còn ${unanswered} câu chưa trả lời!`);
    } else {
        if (!confirm("Bạn chắc chắn muốn nộp bài?")) e.preventDefault();
    }
});

// Hàm toggle flag (đánh dấu cờ đỏ)
function toggleFlag(index) {
    const questionBlock = document.getElementById('question' + index);
    const isFlagged = questionBlock.classList.contains('flagged');
    
    if (isFlagged) {
        questionBlock.classList.remove('flagged'); // Gỡ cờ đỏ
        flaggedQuestions = flaggedQuestions.filter(i => i !== index);
    } else {
        questionBlock.classList.add('flagged'); // Thêm cờ đỏ
        flaggedQuestions.push(index);
    }

    updateSidebarFlagged(); // Cập nhật sidebar
}

// Cập nhật màu sắc các câu hỏi đã đánh dấu cờ đỏ trong sidebar
function updateSidebarFlagged() {
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    sidebarLinks.forEach(link => {
        const index = parseInt(link.getAttribute('data-index'));
        if (flaggedQuestions.includes(index)) {
            link.style.color = 'red'; // Đổi màu cho câu hỏi đã đánh dấu
        } else {
            link.style.color = 'blue';
        }
    });
}
</script>
