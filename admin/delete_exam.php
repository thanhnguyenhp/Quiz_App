<?php
include '../config/db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM exams WHERE id=$id");
header('Location: list_exams.php');
