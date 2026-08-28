<?php

session_start();

require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Online shop</title>
</head>

<body>

    <div class="Navigation-bar">
        <a href="#">Home</a>
        <a href="#">About</a>

        <search>
            <form action="/search" method="get">
                <input type="search" name="q" placeholder="Search">
                <button type="submit">Search</button>
            </form>
        </search>

        <a href="#">Contact</a>
    </div>


    <main class="product-list">

        <?php
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product):
        ?>

            <div class="product-card">

                <h2><?= htmlspecialchars($product['name']) ?></h2>

                <img
                    src="<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                >

                <span class="price">
                    <?= htmlspecialchars($product['price']) ?> €
                </span>
                <form action="cart.php" method="post">
    <input
        type="hidden"
        name="product_id"
        value="<?= $product['id'] ?>"
    >

    <button type="submit">
        Add to cart
    </button>
</form>
            </div>

        <?php endforeach; ?>

    </main>

</body>

</html>