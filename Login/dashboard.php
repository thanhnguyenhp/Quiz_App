<?php
session_start();
include '../config/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ bảng users
$user_query = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
$user = $user_query->fetch_assoc();

// Lấy danh sách bài thi
$exams = $conn->query("SELECT * FROM exams");
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f4f6fb, #eaf6ff);
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}
h2 {
    color: #2d3a4b;
    text-align: center;
    margin-top: 20px;
    font-size: 28px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.info-box, .exam-list-box {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    width: 90%;
    max-width: 800px;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.info-box h3 {
    margin-top: 0;
    color: #3498db;
    font-size: 22px;
    text-align: center;
}
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 30px;
}
.info-grid p {
    margin: 5px 0;
    font-size: 16px;
    color: #2d3a4b;
}
.exam-list-box {
    max-height: 350px;
    overflow-y: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table, th, td {
    border: 1px solid #ddd;
}
th, td {
    padding: 12px;
    text-align: center;
    font-size: 16px;
}
th {
    background-color: #3498db;
    color: #fff;
    text-transform: uppercase;
}
tr:nth-child(even) {
    background-color: #f2f8fc;
}
tr:hover {
    background-color: #eaf6ff;
    cursor: pointer;
    transition: background 0.3s;
}
a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
}
.logout-link {
    margin-top: 20px;
    display: inline-block;
    color: #e74c3c;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s;
}
.logout-link:hover {
    color: #c0392b;
}
</style>

<!-- Box thông tin cá nhân -->
<div class="info-box">
    <h3>🧑‍🎓 Thông tin sinh viên</h3>
    <div class="info-grid">
        <p><strong>Mã sinh viên:</strong> <?= htmlspecialchars($user['id']) ?></p>
        <p><strong>Họ và tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($user['date_of_birth']) ?></p>
        <p><strong>Lớp:</strong> <?= htmlspecialchars($user['class']) ?></p>
        <p><strong>Khoa:</strong> <?= htmlspecialchars($user['department']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address']) ?></p>
    </div>
</div>

<!-- Box danh sách bài thi -->
<h2>📚 Danh sách bài thi</h2>
<div class="exam-list-box">
    <table>
        <tr>
            <th>Số thứ tự</th>
            <th>Bài thi</th>
            <th>Hành động</th>
        </tr>

        <?php while($row = $exams->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td>
                <a href="../student/do_exam.php?exam_id=<?= $row['id'] ?>">Làm bài thi</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Link đăng xuất -->
<a class="logout-link" href="logout.php">🚪 Đăng xuất</a>
