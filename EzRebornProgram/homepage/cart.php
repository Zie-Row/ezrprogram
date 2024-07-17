<?php
session_start();
include ('../LogReg/database.php');

// Fetch all products from the database
$sql = "SELECT id, name, price, imagePath FROM product";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = [
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => '../admin/' . $row['imagePath']
        ];
    }
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total = 0;
foreach ($cart as $product_id => $quantity) {
    $total += $products[$product_id]['price'] * $quantity;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (isset($_POST['pay'])) {
        $payment_method = $_POST['payment_method'];
        $email = $_SESSION['email']; 
        $order_date = date('Y-m-d H:i:s'); 
        foreach ($cart as $product_id => $quantity) {
            $product_name = $products[$product_id]['name'];
            $price = $products[$product_id]['price'];
            $sql = "INSERT INTO orders (email, product_name, quantity, price, order_date) VALUES ('$email', '$product_name', $quantity, $price, '$order_date')";
            $conn->query($sql);
        }
    
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
                <li><a href="schedule.php">Events</a></li>
                <li><a href="about.php">About Us</a></li>
                <li class="current"><a href="cart.php">Cart</a></li>
                <li><a href="../LogReg/logout.php">Log Out</a></li>
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
                        <img src="<?php echo htmlspecialchars($products[$product_id]['image']); ?>" alt="<?php echo htmlspecialchars($products[$product_id]['name']); ?>">
                        <span><?php echo htmlspecialchars($products[$product_id]['name']); ?></span>
                        <span>₱<?php echo number_format($products[$product_id]['price'], 2); ?></span>
                        <input type="number" name="quantities[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="0">
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    Total: ₱<?php echo number_format($total, 2); ?>
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
</body>
</html>
<?php $conn->close(); ?>
