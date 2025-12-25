<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$uname = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard | NEAT</title>
<link rel="stylesheet" href="css/style.css">
<style>
  body {
    background: #e8f5e9;
    font-family: Arial, sans-serif;
  }
  .dashboard-box {
    max-width: 480px;
    margin: 80px auto;
    background: #fff;
    padding: 35px 40px;
    border-radius: 18px;
    box-shadow: 0 0 18px rgba(0,0,0,0.08);
    text-align: center;
    animation: fade .4s ease-in-out;
  }
  @keyframes fade {
    from {opacity: 0; transform: translateY(10px)}
    to   {opacity: 1; transform: translateY(0)}
  }
  h1 {
    font-size: 26px;
    color: #007f3b;
    font-weight: bold;
    margin-bottom: 10px;
  }
  .sub {
    font-size: 15px;
    color: #444;
    margin-bottom: 30px;
  }
  .btn {
    display: inline-block;
    padding: 10px 25px;
    background: #00a44e;
    color: #fff !important;
    border-radius: 10px;
    font-size: 16px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.2s;
  }
  .btn:hover {
    background: #00843d;
  }
</style>
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <div class="dashboard-box">
      <h1>Hai, <?= htmlspecialchars($uname) ?>!</h1>
      <p class="sub">Selamat datang di NEAT</p>

      <a href="index.php" class="btn">Masuk ke Beranda</a>
      <br><br>
      <a href="logout.php" class="btn" style="background:#b71c1c">Logout</a>
  </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
