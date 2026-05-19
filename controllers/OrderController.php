<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: ../views/home.php");
    exit();
}

/** @var mysqli $conn */
$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'];

// orders table-e data insert logic
foreach ($cart_items as $medicine_id) {
    // Note: Database-e jodi orders table thake, tobe eita perfectly chbe. 
    // Jhamela erate query column tracking-ta clean rakha hoyeche.
    $sql = "INSERT INTO orders (user_id, medicine_id, status) VALUES (?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $medicine_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Order shesh, ekhon cart khali korun
unset($_SESSION['cart']);

header("Location: ../views/home.php?msg=order_success");
exit();
