<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$expense_id = intval($_GET['id']);

// Ensure the expense belongs to the logged-in user
$stmt = $conn->prepare("SELECT id FROM expenses WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $expense_id, $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Either the expense doesn't exist or it doesn't belong to the user
    header("Location: dashboard.php");
    exit();
}

// Delete the expense
$delete = $conn->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
$delete->bind_param("ii", $expense_id, $uid);
$delete->execute();

header("Location: dashboard.php");
exit();
