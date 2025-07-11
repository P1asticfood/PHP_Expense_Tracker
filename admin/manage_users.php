<?php
require_once '../config.php';
require_once '../db.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

include 'includes/admin_header.php';

$res = $conn->query("SELECT * FROM users WHERE role = 'user'");
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Manage Users</h4>
        </div>
        <div class="card-body">
            <?php if ($res->num_rows > 0): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn = 1; ?>
                        <?php while ($row = $res->fetch_assoc()): ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <a href="delete_user.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this user?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No users found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
