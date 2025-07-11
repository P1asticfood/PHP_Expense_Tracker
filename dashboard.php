<?php
// session_start();
require_once 'config.php';
require_once 'db.php';
// require 'db.php';
// include __DIR__ . '/includes/header.php';
include 'includes/header.php';

// if (!isset($_SESSION["user_id"])) {
//     header("Location: login.php");
//     exit();
// }
$uid = $_SESSION["user_id"];
$res = $conn->query("SELECT * FROM expenses WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Expenses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- <nav>
    <div class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Expense Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_expense.php">Add Expense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
    </nav> -->

<body>

    <div class=" container mt-5">
        <h2 class="mb-4">Your Expenses</h2>
        <a href="add_expense.php" class="btn btn-primary mb-3">Add New Expense</a>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td>Rs. <?= htmlspecialchars($row['amount']) ?></td>
                        <td>
                            <a href="edit_expense.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_expense.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this expense?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<!-- <?= include 'includes/footer.php'; ?> -->