<?php
// contact.php
include 'db.php';

$feedback = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $feedback = "Lengkapi semua field!";
    } else {
        // buat table contact_messages kalau belum ada (opsional)
        $create = "CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(120),
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $create);

        $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
        if (mysqli_stmt_execute($stmt)) {
            $feedback = "Pesan berhasil dikirim. Terima kasih!";
        } else {
            $feedback = "Gagal mengirim pesan.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contact | NEAT.</title>
  <link rel="stylesheet" href="css/style.css" />
  <script defer src="js/script.js"></script>
</head>
<body>
  <?php include 'header.php'; ?>

  <main>
    <h1>Hubungi Kami</h1>

    <?php if($feedback): ?>
      <p class="feedback" style="color:<?= (strpos($feedback,'berhasil')!==false)?'#008a4a':'#c00' ?>"><?= htmlspecialchars($feedback) ?></p>
    <?php endif; ?>

    <form id="contactForm" class="contact-form" method="POST" action="contact.php">
      <input type="text" name="name" id="name" placeholder="Nama Lengkap" required>
      <input type="email" name="email" id="email" placeholder="Email" required>
      <textarea name="message" id="message" placeholder="Pesan Anda..." required></textarea>
      <button type="submit" class="btn primary">Kirim Pesan</button>
    </form>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
