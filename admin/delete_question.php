<?php
include '../config/db.php';
$id = $_GET['id'];
$exam_id = $_GET['exam_id'];

$conn->query("DELETE FROM questions WHERE id=$id");

header("Location: list_questions.php?exam_id=$exam_id");
