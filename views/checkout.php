<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/** @var mysqli $conn */
$cart_items = $_SESSION['cart'] ?? [];
$medicines = [];

if (!empty($cart_items)) {
    $ids = implode(",", array_map('intval', $cart_items));
    $sql = "SELECT * FROM medicines WHERE id IN ($ids)";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $medicines[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkout - Shopping Cart</title>
    <link rel="stylesheet" href="../public/contact.css">
    <style>
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .btn-confirm {
            background-color: #27ae60;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <h2>Your Shopping Cart</h2>
        <?php if (empty($medicines)): ?>
            <p>Your cart is empty! <a href="home.php">Go back to shop</a></p>
        <?php else: ?>
            <form action="../controllers/OrderController.php" method="post">
                <?php $total = 0;
                foreach ($medicines as $med): $total += $med['price']; ?>
                    <div class="item-row">
                        <span><?= htmlspecialchars($med['name']) ?></span>
                        <span><?= $med['price'] ?> BDT</span>
                    </div>
                <?php endforeach; ?>
                <div class="item-row" style="font-weight: bold; margin-top: 10px;">
                    <span>Total:</span>
                    <span><?= $total ?> BDT</span>
                </div>
                <button type="submit" class="btn-confirm">Confirm & Place Order</button>
            </form>
            <p style="text-align: center;"><a href="home.php">Continue Shopping</a></p>
        <?php endif; ?>
    </div>
</body>

</html>