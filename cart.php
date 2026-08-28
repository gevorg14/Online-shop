<?php

session_start();

require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productId = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$productId])) {

        $_SESSION['cart'][$productId]++;

    } else {

        $_SESSION['cart'][$productId] = 1;

    }
}

$cart = $_SESSION['cart'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Shopping cart</h1>

    <?php if (empty($cart)): ?>

        <p>Your cart is empty.</p>

    <?php else: ?>

        <?php foreach ($cart as $productId => $quantity): ?>

            <?php

            $stmt = $pdo->prepare(
                "SELECT * FROM products WHERE id = ?"
            );

            $stmt->execute([$productId]);

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            ?>

            <div class="cart-item">

                <h2>
                    <?= htmlspecialchars($product['name']) ?>
                </h2>

                <img
                    src="<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    width="150"
                >

                <p>
                    Price:
                    <?= htmlspecialchars($product['price']) ?> €
                </p>

                <p>
                    Quantity:
                    <?= $quantity ?>
                </p>

                <p>
                    Total:
                    <?= $product['price'] * $quantity ?> €
                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</body>

</html>