<?php
require '../config.php';
require '../db.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

include 'includes/admin_header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0">Admin Dashboard</h3>
            </div>
            <div class="card-body">
                <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
                <div class="list-group">
                    <a href="manage_users.php" class="list-group-item list-group-item-action">
                        👤 Manage Users
                    </a>
                    <a href="view_expenses.php" class="list-group-item list-group-item-action">
                        💼 View All Expenses
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
