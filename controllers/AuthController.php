<?php
require_once "../config/db.php";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'register') {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $address  = trim($_POST["address"]);
    $phone    = trim($_POST["phone"]);
    $role     = $_POST["role"];

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password_hash, role, address, phone) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $hashed_pass, $role, $address, $phone);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration Successful! <a href='../views/login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

$action = $_GET['action'] ?? "";
if ($action == 'login' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, password_hash, role FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $user['password_hash'])) {

            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../views/home.php");
            exit();
        } else {
            echo "Invalid Password!";
        }
    } else {
        echo "No user found with this email!";
    }
    mysqli_stmt_close($stmt);
}


if ($action == 'update_profile' && $_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];


    $target_dir = "../public/uploads/";
    $file_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        $sql = "UPDATE users SET name=?, phone=?, profile_picture=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $file_name, $user_id);
    } else {
        $sql = "UPDATE users SET name=?, phone=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $phone, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['name'] = $name; 
        header("Location: ../views/profile.php?msg=updated");
    }
    mysqli_stmt_close($stmt);
}
