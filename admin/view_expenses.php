<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

include 'includes/admin_header.php'; // Optional: or use a separate admin_header.php

// Fetch all expenses with user info
$sql = "SELECT expenses.*, users.username 
        FROM expenses 
        INNER JOIN users ON expenses.user_id = users.id 
        ORDER BY expenses.date DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">All User Expenses</h4>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td>Rs. <?= number_format($row['amount'], 2) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td><?= date("d M Y", strtotime($row['date'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">No expense records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
