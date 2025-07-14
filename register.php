<?php
require_once 'db.php';
require_once 'config.php';

$errors = [
    'username' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'gender' => '',
];

$old = [
    'username' => '',
    'email' => '',
    'gender' => '',
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = "This field is required";
        } else {
            if (isset($old[$key])) {
                $old[$key] = htmlspecialchars($value);
            }
        }
    }

    $username = $_POST['username'];
    $email=$_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $errors['username'] = "Username already exists";
    }

    // Confirm password check
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }
    $password = md5($password);
    $gender = $_POST['gender'];


    // Final submission
    if (!array_filter($errors)) {
        $sql = "INSERT INTO users(username, email, password, gender) VALUES ('$username', '$email', '$password', '$gender')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $_SESSION['success'] = "user added sucessfully";
            redirect("login.php");
        } else {
            $errors['username'] = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-form {
            max-width: 500px;
            margin: 4rem auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-label span {
            font-size: 0.875rem;
        }

        .btn-register {
            background-color: #0DCAF0;
            color: white;
            font-weight: 500;
        }

        .btn-register:hover {
            background-color: #16a6cb;
        }
    </style>
</head>

<body>
    <div class="register-form">
        <h3 class="text-center mb-4">Register Account</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Username:
                    <span class="text-danger"><?= $errors['username']; ?></span>
                </label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $old['username'] ?>"
                    placeholder="Username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:
                    <span class="text-danger"><?= $errors['email']; ?></span>
                </label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $old['email'] ?>"
                    placeholder="you@example.com" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password:
                        <span class="text-danger"><?= $errors['password']; ?></span>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password:
                        <span class="text-danger"><?= $errors['confirm_password']; ?></span>
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="gender" class="form-label">Gender:
                    <span class="text-danger"><?= $errors['gender']; ?></span>
                </label>
                <select class="form-select" name="gender" id="gender" required>
                    <option value="">--- Select Gender ---</option>
                    <option value="male" <?= $old['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $old['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= $old['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <button type="submit" class="btn btn-register w-100"><a href="login.php">Register</a></button>
        </form>
        <div class="text-center mt-3">
            <small>Already registered? <a href="login.php">Login here</a></small>
        </div>
    </div>

</body>

</html>