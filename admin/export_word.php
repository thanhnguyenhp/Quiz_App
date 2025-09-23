<?php
require_once '../vendor/autoload.php'; // đường dẫn tùy theo cấu trúc dự án

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

include '../config/db.php';

$query = "
SELECT 
    u.id AS student_id,
    u.name AS student_name,
    u.class AS class_name,
    ROUND((r.correct_answers / r.total_questions) * 10, 1) AS score,
    SUBSTRING_INDEX(u.name, ' ', -1) AS last_name
FROM 
    exam_results r
JOIN 
    users u ON r.student_name = u.name
ORDER BY 
    last_name ASC, u.name ASC
";

$result = $conn->query($query);

$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Tiêu đề
$section->addText("BẢNG ĐIỂM SINH VIÊN", ['bold' => true, 'size' => 16], ['align' => 'center']);
$section->addTextBreak(1);

// Tạo bảng
$table = $section->addTable(['borderSize' => 6, 'borderColor' => '999999']);

// Tiêu đề cột
$table->addRow();
$table->addCell(2500)->addText('Họ và tên');
$table->addCell(1500)->addText('Mã SV');
$table->addCell(1500)->addText('Lớp');
$table->addCell(1000)->addText('Điểm');
$table->addCell(2000)->addText('Ghi chú');
$table->addCell(2000)->addText('Chữ ký');

// Dữ liệu bảng
while ($row = $result->fetch_assoc()) {
    $table->addRow();
    $table->addCell(2500)->addText($row['student_name']);
    $table->addCell(1500)->addText($row['student_id']);
    $table->addCell(1500)->addText($row['class_name']);
    $table->addCell(1000)->addText($row['score']);
    $table->addCell(2000)->addText(''); 
    $table->addCell(2000)->addText(''); 
}

// Xuất file
$filename = "Bang_Diem_Sinh_Vien.docx";
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save("php://output");
exit;
