<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $medicine_id = intval($_POST['medicine_id']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!in_array($medicine_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $medicine_id;
    }

    header("Location: ../views/home.php?msg=added_to_cart");
    exit();
}
