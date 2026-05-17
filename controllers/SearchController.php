<?php
require_once "../config/db.php";

/** @var mysqli $conn */  // EI LINE-TI ADD KORUN
// Eita likhle VS Code bujhe jabe $conn hocche mysqli connection variable

$q = $_GET['q'] ?? "";
$category = $_GET['category'] ?? "";

// SQL structure: Category thakle AND clause jog hobe
$sql = "SELECT m.*, c.name as category_name, c.category_type 
        FROM medicines m 
        JOIN categories c ON m.category_id = c.id 
        WHERE m.name LIKE ?";

if ($category != "") {
    $sql .= " AND c.category_type = ?";
}

$stmt = mysqli_prepare($conn, $sql);

if ($category != "") {
    $searchTerm = "%$q%";
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $category);
} else {
    $searchTerm = "%$q%";
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Medicine Card Display logic
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='medicine-card'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category_name']) . " (" . $row['category_type'] . ")</p>";
        echo "<p><strong>Vendor:</strong> " . htmlspecialchars($row['vendor_name']) . "</p>";
        echo "<p><strong>Price:</strong> " . $row['price'] . " BDT</p>";
        echo "<p><strong>Stock:</strong> " . $row['availability'] . " left</p>";
        echo "<button>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "<p style='padding: 20px;'>No medicines found matching your search.</p>";
}

mysqli_stmt_close($stmt);
