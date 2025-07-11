<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION["user_id"];
    $title = $_POST["title"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];
    $category = $_POST["category"];

    $stmt = $conn->prepare("INSERT INTO expenses (user_id, title, amount, category, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $uid, $title, $amount, $category, $date);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Expense</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" required step="0.01" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" name="category" id="category" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Add Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</div> <!-- End row --> 