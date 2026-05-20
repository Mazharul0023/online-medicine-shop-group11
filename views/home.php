<?php
session_start();
require_once "../config/db.php";
/** @var mysqli $conn */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT m.*, c.name as category_name FROM medicines m JOIN categories c ON m.category_id = c.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home - Online Medicine Shop</title>
    <link rel="stylesheet" href="../public/contact.css">
    <style>
        .medicine-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .medicine-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            width: 250px;
            box-shadow: 2px 2px 5px #eee;
        }

        .search-box {
            margin: 20px;
            padding: 10px;
            width: 300px;
        }

        .filter-box {
            padding: 10px;
            width: 200px;
        }
    </style>
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']); ?>!</h1>

    <div style="padding-left: 20px;">
        <input type="text" id="searchBar" class="search-box" placeholder="Search medicine by name..." onkeyup="searchMedicine()">

        <select id="categoryFilter" class="filter-box" onchange="searchMedicine()">
            <option value="">All Categories</option>
            <option value="liquid">Liquid</option>
            <option value="solid">Solid</option>
        </select>
    </div>

    <div class="medicine-container" id="medicineList">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="medicine-card">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><strong>Category:</strong> <?= htmlspecialchars($row['category_name']) ?></p>
                <p><strong>Vendor:</strong> <?= htmlspecialchars($row['vendor_name']) ?></p>
                <p><strong>Price:</strong> <?= $row['price'] ?> BDT</p>
                <p><strong>Stock:</strong> <?= $row['availability'] ?> left</p>
                <button>Add to Cart</button>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        function searchMedicine() {
            let input = document.getElementById('searchBar').value;
            let category = document.getElementById('categoryFilter').value;
            let xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('medicineList').innerHTML = this.responseText;
                }
            };
            
            xhttp.open("GET", "../controllers/SearchController.php?q=" + input + "&category=" + category, true);
            xhttp.send();
        }
    </script>
</body>

</html>