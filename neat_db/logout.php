<?php
// logout.php
include 'db.php';

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    $sql = "UPDATE login_log
            SET logout_time = CURRENT_TIMESTAMP
            WHERE user_id = ? AND logout_time IS NULL
            ORDER BY login_id DESC
            LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
