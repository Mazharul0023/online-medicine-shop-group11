<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $medicine_id = intval($_POST['medicine_id']);

    // Cart session initialized if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add medicine ID to cart session
    if (!in_array($medicine_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $medicine_id;
    }

    header("Location: ../views/home.php?msg=added_to_cart");
    exit();
}
