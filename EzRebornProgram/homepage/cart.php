<?php
session_start();

// Example cart data (in a real application, this would be fetched from a database)
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Example products (in a real application, this would be fetched from a database)
$products = [
    1 => ['name' => 'Gaming Mouse', 'price' => 49.99, 'image' => 'img/product1.jpg'],
    2 => ['name' => 'Mechanical Keyboard', 'price' => 99.99, 'image' => 'img/product2.jpg'],
    3 => ['name' => 'Gaming Headset', 'price' => 79.99, 'image' => 'img/product3.jpg'],
    4 => ['name' => 'Gaming Chair', 'price' => 199.99, 'image' => 'img/product4.jpg'],
];

// Calculate total price
$total = 0;
foreach ($cart as $product_id => $quantity) {
    $total += $products[$product_id]['price'] * $quantity;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update cart quantities
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            if ($quantity <= 0) {
                unset($cart[$product_id]);
            } else {
                $cart[$product_id] = $quantity;
            }
        }
        $_SESSION['cart'] = $cart;
        header('Location: cart.php');
        exit();
    }

    // Handle payment
    if (isset($_POST['pay'])) {
        $payment_method = $_POST['payment_method'];
        // Redirect to payment gateway or handle payment processing here
        // For demonstration, we will just display a success message
        echo "<script>alert('Payment successful using $payment_method!');</script>";
        $cart = [];
        $_SESSION['cart'] = $cart;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - EZReborn</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            padding: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-item img {
            width: 100px;
            height: auto;
        }
        .cart-total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .payment-methods {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="img/EzR Logo.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="current"><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main class="cart-container">
        <h2>Your Cart</h2>
        <form method="post" action="cart.php">
            <?php if (empty($cart)) : ?>
                <p>Your cart is empty.</p>
            <?php else : ?>
                <?php foreach ($cart as $product_id => $quantity) : ?>
                    <div class="cart-item">
                        <img src="<?php echo $products[$product_id]['image']; ?>" alt="<?php echo $products[$product_id]['name']; ?>">
                        <span><?php echo htmlspecialchars($products[$product_id]['name']); ?></span>
                        <span>$<?php echo number_format($products[$product_id]['price'], 2); ?></span>
                        <input type="number" name="quantities[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="0">
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    Total: $<?php echo number_format($total, 2); ?>
                </div>
                <button type="submit" name="update_cart">Update Cart</button>
            <?php endif; ?>
        </form>

        <?php if (!empty($cart)) : ?>
            <div class="payment-methods">
                <h3>Choose Payment Method</h3>
                <form method="post" action="cart.php">
                    <input type="radio" name="payment_method" value="e-bank" id="e-bank" required>
                    <label for="e-bank">E-Bank</label><br>
                    <input type="radio" name="payment_method" value="gcash" id="gcash" required>
                    <label for="gcash">GCash</label><br>
                    <button type="submit" name="pay">Pay Now</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 EZReborn E-Sports. All rights reserved.</p>
        <ul>
            <li><a href="privacy.php">Privacy Policy</a></li>
            <li><a href="terms.php">Terms of Service</a></li>
        </ul>
    </footer>
</body>
</html>
