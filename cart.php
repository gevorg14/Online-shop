<?php

session_start();

require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productId = (int) $_POST['product_id'];
    $action = $_POST['action'] ?? 'add';


    // Add product
    if ($action === 'add') {

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }

    }


    // Increase product quantity
    if ($action === 'increase') {

        $_SESSION['cart'][$productId]++;

    }


    // Decrease product quantity
    if ($action === 'decrease') {

        $_SESSION['cart'][$productId]--;

        // Remove product if quantity reaches zero
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }

    }


    // Remove product from cart
    if ($action === 'remove') {

        unset($_SESSION['cart'][$productId]);

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navigation-bar">

    <a href="index.php">Home</a>

    <a href="#">About</a>

    <search>
        <form action="/search" method="get">

            <input
                type="search"
                name="q"
                placeholder="Search"
            >

            <button type="submit">
                Search
            </button>

        </form>
    </search>

    <a href="cart.php">Cart</a>

</nav>


<main>

    <h1>Shopping Cart</h1>

    <div class="cart-list">

        <?php if (empty($_SESSION['cart'])): ?>

            <p>Your cart is empty.</p>

        <?php else: ?>

            <?php

            // Store the total price of all products in the cart
            $grandTotal = 0;


            // Loop through all products in the cart
            foreach ($_SESSION['cart'] as $productId => $quantity):

                // Get product information from the database
                $stmt = $pdo->prepare(
                    "SELECT * FROM products WHERE id = ?"
                );

                $stmt->execute([$productId]);

                $product = $stmt->fetch(PDO::FETCH_ASSOC);


                // Calculate total price for this product
                $total = $product['price'] * $quantity;

                // Add product total to the cart total
                $grandTotal += $total;

            ?>

                <div class="cart-card">

                    <img
                        src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                    >

                    <h2>
                        <?= htmlspecialchars($product['name']) ?>
                    </h2>

                    <p>
                        <?= htmlspecialchars($product['description']) ?>
                    </p>

                    <span class="price">
                        <?= htmlspecialchars($product['price']) ?> €
                    </span>


                    <!-- Product quantity controls -->
                    <div class="quantity">

                        <!-- Decrease quantity -->
                        <form action="cart.php" method="post">

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $productId ?>"
                            >

                            <input
                                type="hidden"
                                name="action"
                                value="decrease"
                            >

                            <button type="submit">
                                −
                            </button>

                        </form>


                        <span>
                            <?= $quantity ?>
                        </span>


                        <!-- Increase quantity -->
                        <form action="cart.php" method="post">

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $productId ?>"
                            >

                            <input
                                type="hidden"
                                name="action"
                                value="increase"
                            >

                            <button type="submit">
                                +
                            </button>

                        </form>

                    </div>


                    <!-- Total price for this product -->
                    <p>
                        Total:
                        <strong>
                            <?= number_format($total, 2) ?> €
                        </strong>
                    </p>


                    <!-- Remove product from cart -->
                    <form action="cart.php" method="post">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $productId ?>"
                        >

                        <input
                            type="hidden"
                            name="action"
                            value="remove"
                        >

                        <button type="submit">
                            Remove
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>


    <?php if (!empty($_SESSION['cart'])): ?>

        <!-- Display the total price of the entire cart -->
        <div class="cart-total">

            <h2>
                Grand Total:
                <?= number_format($grandTotal, 2) ?> €
            </h2>

            <button type="button">
                Checkout
            </button>

        </div>

    <?php endif; ?>

</main>

</body>
</html>