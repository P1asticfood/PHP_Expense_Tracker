<?php
require_once 'config.php';
require_once 'db.php';
include 'includes/header.php';

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
<body>

    <div class=" container mt-5">
        <h2 class="mb-4">Your Expenses</h2>
        <a href="add_expense.php" class="btn btn-primary mb-3">Add New Expense</a>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
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


<?= include 'includes/footer.php'; ?>