<?php
// about.php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About | NEAT.</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <main>
    <h1>Tentang Kami</h1>
    <img src="image/NEAT Logo.png" alt="Logo NEAT" class="about-logo">

    <p><strong>NEAT.</strong> adalah singkatan dari <em>Need & Eat</em> — yang berarti *Butuh Makan*.  
    Kami hadir sebagai solusi cepat dan sehat untuk kamu yang sibuk namun tetap ingin menikmati makanan bergizi.  
    Setiap hidangan kami dibuat dengan bahan segar, penuh rasa, dan tentunya dengan cinta.</p>

    <br>
    <h2>Lokasi Kami</h2>
    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.123456789!2d112.7357866!3d-7.3195636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7881f1f1f1f1f1%3A0x1234567890abcdef!2sJl.%20Ketintang%20No.156%2C%20Ketintang%2C%20Kec.%20Gayungan%2C%20Surabaya%2C%20Jawa%20Timur%2060231!5e0!3m2!1sid!2sid!4v1616161616161!5m2!1sid!2sid" 
        width="600" 
        height="400" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
      </iframe>
    </div>
    <br>
    <a href="https://maps.app.goo.gl/meWZBXXsNx4T4FFS6" target="_blank" class="maps-link">Lihat di Google Maps</a>
  </main>

  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>
</body>
</html>
