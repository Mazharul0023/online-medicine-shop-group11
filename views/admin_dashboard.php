<?php

session_start();

require_once "../config/db.php";

// Admin check logic

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {

        echo "Access Denied! Admin access only.";

        exit();
}

// Medicine list fetch kora (Category name shoho)

$sql = "SELECT m.*, c.name as category_name FROM medicines m 

        LEFT JOIN categories c ON m.category_id = c.id";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="../public/contact.css">
        <style>
                body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                }

                .dashboard-container {
                        max-width: 1000px;
                        margin: auto;
                        background: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                }

                th,
                td {
                        border: 1px solid #ddd;
                        padding: 12px;
                        text-align: left;
                }

                th {
                        background-color: #2c3e50;
                        color: white;
                }

                .btn {
                        padding: 8px 12px;
                        text-decoration: none;
                        border-radius: 4px;
                        font-weight: bold;
                }

                .btn-add {
                        background: #27ae60;
                        color: white;
                        margin-bottom: 15px;
                        display: inline-block;
                }

                .btn-edit {
                        background: #3498db;
                        color: white;
                        font-size: 12px;
                }

                .btn-delete {
                        background: #e74c3c;
                        color: white;
                        font-size: 12px;
                }
        </style>
</head>

<body>

        <div class="dashboard-container">
                <h2>Admin Dashboard - Medicine Management</h2>
                <a href="add_medicine.php" class="btn btn-add">+ Add New Medicine</a>
                <a href="home.php" style="float: right;">Back to Home</a>
                <table>
                        <thead>
                                <tr>
                                        <th>Medicine Name</th>
                                        <th>Category</th>
                                        <th>Vendor</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                                        <td><?= htmlspecialchars($row['category_name'] ?? 'N/A') ?></td>
                                                        <td><?= htmlspecialchars($row['vendor_name'] ?? 'N/A') ?></td>
                                                        <td><?= $row['price'] ?> BDT</td>
                                                        <td><?= $row['availability'] ?></td>
                                                        <td>
                                                                <a href="edit_medicine.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                                                <a href="../controllers/AdminController.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                                        </td>
                                                </tr>
                                        <?php endwhile; ?>
                                <?php else: ?>
                                        <tr>
                                                <td colspan="6" align="center">No medicines found!</td>
                                        </tr>
                                <?php endif; ?>
                        </tbody>
                </table>
        </div>

</body>

</html>