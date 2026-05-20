<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied! Admin access only.";
    exit();
}

/** @var mysqli $conn */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $vendor = trim($_POST['vendor']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO medicines (name, category_id, vendor_name, price, availability) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sisdi", $name, $category_id, $vendor, $price, $stock);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin_dashboard.php?msg=added");
        exit();
    } else {
        $error = "Error adding medicine!";
    }
    mysqli_stmt_close($stmt);
}

$cat_sql = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Medicine</title>
    <link rel="stylesheet" href="../public/contact.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add New Medicine</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Medicine Name" required>

            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php while ($cat = mysqli_fetch_assoc($cat_result)): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <input type="text" name="vendor" placeholder="Vendor Name" required>
            <input type="number" step="0.01" name="price" placeholder="Price (BDT)" required>
            <input type="number" name="stock" placeholder="Initial Stock" required>

            <button type="submit">Save Medicine</button>
            <a href="admin_dashboard.php" style="display:block; text-align:center; color:#7f8c8d;">Cancel</a>
        </form>
    </div>
</body>

</html>