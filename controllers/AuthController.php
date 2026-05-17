<?php
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'register') {
    // crud.php onujayi trim kora
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $address  = trim($_POST["address"]);
    $phone    = trim($_POST["phone"]);
    $role     = $_POST["role"];

    // Appendix B onujayi password hashing
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    // Prepared Statement setup (cite: 1653)
    $sql = "INSERT INTO users (name, email, password_hash, role, address, phone) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // "ssssss" mane 6 ta string type parameters (cite: 1655, 1667)
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $hashed_pass, $role, $address, $phone);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration Successful! <a href='../views/login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}
