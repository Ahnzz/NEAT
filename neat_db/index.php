<?php
// index.php
include 'db.php';
?>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Menu | NEAT.</title>
  <link rel="stylesheet" href="css/style.css" />
  <script defer src="js/script.js"></script>
</head>
<body>
  <?php include 'header.php'; ?>

<main class="home-layout">
  <div class="highlight">
    <section class="hero">
      <h1>Butuh Makan? <span>NEAT.</span></h1>
      <p class="hero-sub">Sajian nikmat, hangat, dan bikin mood jadi better — cobain sekarang.</p>
      <a class="btn" href="menu.php">Lihat Menu</a>
    </section>

    <div class="features-section">
      <section class="features">
        <div class="feature">
          <h3>Rasa Berkualitas</h3>
          <p>Bahan segar, resep jeli, hasil yang memuaskan.</p>
        </div>
        <div class="feature">
          <h3>Pelayanan Cepat</h3>
          <p>Order mudah, siap saji cepat.</p>
        </div>
        <div class="feature">
          <h3>Suasana Nyaman</h3>
          <p>Tempat cozy untuk santai dan kerja.</p>
        </div>
      </div>

    <div class="hours-section">  
        <section class="operational-hours">
          <p class="hero-sub">Sajian nikmat, hangat, dan bikin mood lebih baik.</p>
          <p class="hero-hours">Jam Operasional: Senin - Minggu, 08:00 - 22:00</p>
        </section>
      </div>
    </div>

  <div class="picture-section">
    <img src="image/guest_space.jpeg" alt="NEAT Food Display">
  </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
