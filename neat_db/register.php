<?php
// register.php
include 'db.php';

$err = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $err = "Lengkapi semua field.";
    } else {
        // cek username/email exist
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username=? OR email=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $err = "Username atau email sudah terdaftar.";
            mysqli_stmt_close($stmt);
        } else {
            mysqli_stmt_close($stmt);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';
            $stmt2 = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, "ssss", $username, $email, $hash, $role);
            if (mysqli_stmt_execute($stmt2)) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $err = "Gagal registrasi: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register | NEAT</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
  <div class="auth-box">
    <h1>Register</h1>
    <?php if($err): ?><p style="color:#c00"><?= htmlspecialchars($err) ?></p><?php endif; ?>
    <form method="POST" action="register.php" class="contact-form">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button class="btn primary" type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
  </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
