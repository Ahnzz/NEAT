<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<header>
  <nav class="navbar">

    <!-- KIRI: Logo -->
    <div class="nav-left">
      <a href="index.php" class="logo">
        <img src="image/NEAT Logo.png" alt="NEAT Logo">
      </a>
    </div>

    <!-- TENGAH: NAV LINKS -->
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])=='index.php' ? 'active' : '' ?>">Home</a></li>
      <li><a href="menu.php" class="<?= basename($_SERVER['PHP_SELF'])=='menu.php' ? 'active' : '' ?>">Menu</a></li>
      <li><a href="about.php" class="<?= basename($_SERVER['PHP_SELF'])=='about.php' ? 'active' : '' ?>">About</a></li>
      <li><a href="contact.php" class="<?= basename($_SERVER['PHP_SELF'])=='contact.php' ? 'active' : '' ?>">Contact</a></li>

      <?php if(isset($_SESSION['user_id'])): ?>
        <li><a href="dashboard.php">Hai, <?= htmlspecialchars($_SESSION['username']) ?></a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php" class="<?= basename($_SERVER['PHP_SELF'])=='login.php' ? 'active' : '' ?>">Login</a></li>
        <li><a href="register.php" class="<?= basename($_SERVER['PHP_SELF'])=='register.php' ? 'active' : '' ?>">Register</a></li>
      <?php endif; ?>
    </ul>

    <!-- KANAN: CART & HAMBURGER -->
    <div class="nav-right">
      <?php if(basename($_SERVER['PHP_SELF'])=='menu.php'): ?>
        <div class="cart-icon" id="cartBtnWrap">
          <button id="cartBtn" class="cart-btn" aria-label="Keranjang">🛒</button>
          <span id="cartCount" class="cart-count">0</span>
        </div>
      <?php endif; ?>
        <!-- HAMBURGER BUTTON -->
        <button class="hamburger" id="hamburgerBtn">☰</button>

        <!-- HAMBURGER OVERLAY -->
        <div class="hamburger-overlay" id="hamburgerOverlay">
          <button class="close-btn" id="closeHamburger">✕</button>

          <nav class="hamburger-nav">
            <a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])=='index.php' ? 'active' : '' ?>">Home</a>
            <a href="menu.php" class="<?= basename($_SERVER['PHP_SELF'])=='menu.php' ? 'active' : '' ?>">Menu</a>
            <a href="about.php" class="<?= basename($_SERVER['PHP_SELF'])=='about.php' ? 'active' : '' ?>">About</a>
            <a href="contact.php" class="<?= basename($_SERVER['PHP_SELF'])=='contact.php' ? 'active' : '' ?>">Contact</a>
            <?php if(isset($_SESSION['user_id'])): ?>
              <li><a href="dashboard.php">Hai, <?= htmlspecialchars($_SESSION['username']) ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
              <li><a href="login.php" class="<?= basename($_SERVER['PHP_SELF'])=='login.php' ? 'active' : '' ?>">Login</a></li>
            <?php endif; ?>
          </nav>
        </div>
    </div>
  </nav>
</header>