<?php
session_start();
require_once "../config/db.php";

/** @var mysqli $conn */  // EI LINE-TI ADD KORUN
// Eita likhle VS Code bujhe jabe $conn hocche mysqli connection variable

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../public/contact.css">
</head>

<body>
    <h2>My Profile</h2>
    <form action="../controllers/AuthController.php?action=update_profile" method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>Profile Picture</td>
                <td>
                    <img src="../public/uploads/<?= $user['profile_picture'] ?? 'default.png' ?>" width="100"><br>
                    <input type="file" name="profile_pic">
                </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" value="<?= $user['name'] ?>"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="<?= $user['email'] ?>" readonly></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="text" name="phone" value="<?= $user['phone'] ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Update Profile"></td>
            </tr>
        </table>
    </form>
</body>

</html>