<?php
require_once 'db.php';
require_once 'config.php';

$errors = [
    // 'username' => '',
    'email' => '',
    'password' => '',
];

$old = [
    // 'username' => '',
    'email' => '',
];

if (isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}

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

    if (!array_filter($errors)) {
        // $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();

            // Assuming you used md5 hash in registration; if you used password_hash, use password_verify here
            if (md5($password) === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                $errors['password'] = "Incorrect password";
            }
        } else {
            $errors['email'] = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-form {
      max-width: 400px;
      margin: 5rem auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .btn-login {
      background-color: #0DCAF0;
      color: white;
      font-weight: 500;
    }

    .btn-login:hover {
      background-color: #16a6cb;
    }
  </style>
</head>
<body>

<div class="login-form">
  <h3 class="text-center mb-4">Login</h3>
  <form method="post" action="">
    <!-- <div class="mb-3">
      <label for="username" class="form-label">Username:
        <span class="text-danger"><?= $errors['username'] ?></span>
      </label>
      <input type="text" id="username" name="username" class="form-control" value="<?= $old['username'] ?>" required />
    </div> -->
    <div class="mb-3">
      <label for="email" class="form-label">Email:
        <span class="text-danger"><?= $errors['email'] ?></span>
      </label>
      <input type="email" id="email" name="email" class="form-control" value="<?= $old['email'] ?>" required />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password:
        <span class="text-danger"><?= $errors['password'] ?></span>
      </label>
      <input type="password" id="password" name="password" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-login w-100">Login</button>
  </form>
  <div class="text-center mt-3">
    <small>Don't have an account? <a href="register.php">Register here</a></small>
  </div>
</div>

</body>
</html>
