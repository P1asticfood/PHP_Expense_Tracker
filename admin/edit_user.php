<?php
require_once '../config.php';
require_once '../db.php';

// Redirect if not admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// Validate user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID.");
}
$user_id = intval($_GET['id']);
$message = "";
$errors = [
    'username' => '',
    'email' => '',
    'role' => '',
];

$old = [
    'username' => '',
    'email' => '',
    'role' => '',
];

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}

// Set defaults
$old['username'] = $user['username'];
$old['email'] = $user['email'];
$old['role'] = $user['role'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (['username', 'email', 'role'] as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        } else {
            $old[$field] = htmlspecialchars(trim($_POST[$field]));
        }
    }

    if (!array_filter($errors)) {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $old['username'], $old['email'], $old['role'], $user_id);

        if ($stmt->execute()) {
            $message = "User updated successfully!";
        } else {
            $message = "Error updating user.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5.3.2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php include 'includes/admin_header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($old['username']) ?>" class="form-control" required>
                            <div class="text-danger small"><?= $errors['username']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" class="form-control" required>
                            <div class="text-danger small"><?= $errors['email']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">--- Select Role ---</option>
                                <option value="user" <?= $old['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $old['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="superadmin" <?= $old['role'] == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                                <option value="banned" <?= $old['role'] == 'banned' ? 'selected' : '' ?>>Banned</option>
                            </select>
                            <div class="text-danger small"><?= $errors['role']; ?></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="manage_users.php" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

</body>
</html>
