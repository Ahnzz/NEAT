<?php
// menu.php
include 'db.php';

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil semua produk
$query = "SELECT product_id, name, price, category, image_url, description FROM products";


$result = mysqli_query($conn, $query);

// cek query berhasil atau tidak
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// optional: tutup koneksi jika tidak perlu lagi
// mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Menu | NEAT.</title>
  <link rel="stylesheet" href="css/style.css" />
  <script>
    // kirim data PHP ke JS
    const menuData = <?= json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  </script>
  <script defer src="js/script.js"></script>
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <h1>Menu Kami</h1>

  <!-- CATEGORY -->
  <section class="category-selection">
    <div class="category-card active" data-category="main"><h3>Main Course</h3></div>
    <div class="category-card" data-category="snack"><h3>Snack</h3></div>
    <div class="category-card" data-category="coffee"><h3>Coffee</h3></div>
    <div class="category-card" data-category="milk"><h3>Milk Based</h3></div>
  </section>

  <!-- MENU -->
  <section class="menu-container" id="menuGrid"></section>
</main>

<!-- CART MODAL -->
<div class="modal hidden" id="cartModal">
  <div class="modal-content">
    <button class="modal-close" id="closeCart">×</button>
    <h2>Keranjang Belanja</h2>

    <div class="cart-items" id="cartItems"></div>

    <div class="payment-method">
      <label><input type="radio" name="payment" value="qris"> QRIS</label>
      <label><input type="radio" name="payment" value="ewallet"> E-Wallet</label>
      <label><input type="radio" name="payment" value="cash"> Cash</label>
    </div>

    <div class="cart-footer">
      <div>Total: <span id="cartTotal">Rp0</span></div>
      <div>
        <button id="clearCart">Kosongkan</button>
        <button id="checkoutBtn">Checkout</button>
      </div>
    </div>
  </div>
</div>

<!-- SUCCESS -->
<div class="modal hidden centered" id="successModal">
  <div class="modal-content small">
    <button class="modal-close" id="closeSuccess">×</button>
    <h2>Pesanan Berhasil!</h2>
    <p>Terima kasih, pesanan Anda sedang diproses.</p>
  </div>
</div>

<div class="toast hidden" id="toast">Produk ditambahkan ke keranjang</div>

<?php include 'footer.php'; ?>
</body>
</html>
