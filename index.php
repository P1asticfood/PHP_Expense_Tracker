<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Tracker - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Expense Tracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_expense.php">Add Expense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text text-white">
                    Logged in as: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <div class="text-center mb-4">
        <h1 class="display-5">Welcome to Expense Tracker</h1>
        <p class="lead">Manage your personal expenses easily</p>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="list-group shadow">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">🏠 Dashboard</a>
                    <a href="add_expense.php" class="list-group-item list-group-item-action">➕ Add Expense</a>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger">🚪 Logout</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="list-group shadow">
                    <a href="login.php" class="list-group-item list-group-item-action">🔑 Login</a>
                    <a href="register.php" class="list-group-item list-group-item-action">📝 Register</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">
        <p class="mb-0">© <?= date('Y') ?> Expense Tracker</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
