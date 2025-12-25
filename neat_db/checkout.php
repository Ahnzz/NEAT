<?php
session_start();
header("Content-Type: application/json");

include 'db.php';

/* === PAKSA MYSQL JADI EXCEPTION === */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    /* ===== CEK LOGIN ===== */
    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'status' => 'error',
            'msg' => 'User belum login'
        ]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    /* ===== AMBIL JSON ===== */
    $raw  = file_get_contents("php://input");
    $data = json_decode($raw, true);

    $cart   = $data['cart'] ?? [];
    $method = $data['payment_method'] ?? null;

    if (!$method) {
        throw new Exception("Metode pembayaran belum dipilih");
    }

    if (!is_array($cart) || count($cart) === 0) {
        throw new Exception("Cart kosong");
    }

    /* ===== HITUNG TOTAL ===== */
    $total = 0;
    foreach ($cart as $item) {
        $total += ((int)$item['price'] * (int)$item['qty']);
    }

    /* ===== STATUS BERDASARKAN METODE ===== */
    $payment_status = ($method === 'Cash') ? 'Pending' : 'Paid';

    /* ===== INSERT ORDERS ===== */
    $stmt = mysqli_prepare($conn,
        "INSERT INTO orders (user_id, order_date, total_price, status)
         VALUES (?, NOW(), ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $total, $payment_status);
    mysqli_stmt_execute($stmt);

    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    /* ===== INSERT ORDER ITEMS ===== */
    $stmt2 = mysqli_prepare($conn,
        "INSERT INTO order_items (order_id, product_id, qty, price)
         VALUES (?, ?, ?, ?)"
    );

    foreach ($cart as $item) {
        mysqli_stmt_bind_param(
            $stmt2,
            "iiii",
            $order_id,
            $item['id'],
            $item['qty'],
            $item['price']
        );
        mysqli_stmt_execute($stmt2);
    }
    mysqli_stmt_close($stmt2);

    /* ===== INSERT PAYMENT ===== */
    $stmt3 = mysqli_prepare($conn,
        "INSERT INTO payment (order_id, user_id, amount, method, status)
         VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $stmt3,
        "iiiss",
        $order_id,
        $user_id,
        $total,
        $method,
        $payment_status
    );
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_close($stmt3);

    /* ===== RESPONSE ===== */
    echo json_encode([
        'status'   => 'success',
        'order_id' => $order_id
    ]);

} catch (Throwable $e) {

    /* === ERROR SELALU JSON, BUKAN HTML === */
    echo json_encode([
        'status' => 'error',
        'msg'    => $e->getMessage()
    ]);
    exit;
}
