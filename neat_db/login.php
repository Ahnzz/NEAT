<?php
// login.php
session_start();
include 'db.php';

$err = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $err = "Lengkapi semua field.";
    } else {

        // Cek user berdasarkan username atau email
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? OR email=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $usernameOrEmail, $usernameOrEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user) {
            // Fallback: password_verify + plain text check
            if (password_verify($password, $user['password'])) {
                $loginValid = true;
            } elseif ($password === $user['password']) {
                // Password masih plain text → hash sekarang
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $stmtFix = mysqli_prepare($conn, "UPDATE users SET password=? WHERE user_id=?");
                mysqli_stmt_bind_param($stmtFix, "si", $newHash, $user['user_id']);
                mysqli_stmt_execute($stmtFix);
                mysqli_stmt_close($stmtFix);
                $loginValid = true;
            } else {
                $loginValid = false;
            }

            if ($loginValid) {
                // Simpan Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Catat log login
                $ip = $_SERVER['REMOTE_ADDR'];
                $stmt2 = mysqli_prepare($conn, "INSERT INTO login_log (user_id, ip_address) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt2, "is", $user['user_id'], $ip);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);

                // Redirect langsung ke home
                echo "<script>
                    alert('Login berhasil!');
                    window.location.href = 'index.php';
                </script>";
                exit;
            } else {
                $err = "Password salah!";
            }
        } else {
            $err = "User tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login | NEAT</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <div class="auth-box">
    <h1>Login</h1>

    <?php if($err): ?>
        <p style="color:#c00"><?= htmlspecialchars($err) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" class="contact-form">
      <input type="text" name="username" placeholder="Username atau Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button class="btn primary" type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Register</a></p>
  </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
