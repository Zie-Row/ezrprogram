<?php
session_start();

// Example product data (in a real application, this would be fetched from a database)
$products = [
    1 => ['name' => 'Ezr Bomber Jacket', 'price' => 1499.99, 'image' => 'img/product1.jpg', 'category' => 'Clothing'],
    2 => ['name' => 'Ezr Jersey (Black)', 'price' => 450.99, 'image' => 'img/product2.jpg', 'category' => 'Clothing'],
    3 => ['name' => 'EZR Jersey', 'price' => 450.99, 'image' => 'img/product3.jpg', 'category' => 'Clothing'],
    4 => ['name' => '3 in 1 EZR Hoodie', 'price' => 9999.99, 'image' => 'img/product4.jpg', 'category' => 'Bundle'],
];

// Example categories
$categories = ['All', 'Clothing', 'Bundle'];

// Get selected category and search query from query parameters
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'All';
$search_query = isset($_GET['search']) ? strtolower($_GET['search']) : '';

// Filter products by selected category and search query
$filtered_products = array_filter($products, function($product) use ($selected_category, $search_query) {
    $in_category = $selected_category === 'All' || $product['category'] === $selected_category;
    $in_search = empty($search_query) || strpos(strtolower($product['name']), $search_query) !== false;
    return $in_category && $in_search;
});

// Handle add to cart form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header('Location: shop.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - EZReborn</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .shop-container {
            display: flex;
        }
        .categories {
            width: 20%;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .categories ul {
            list-style-type: none;
            padding: 0;
        }
        .categories ul li {
            margin-bottom: 10px;
        }
        .categories ul li a {
            text-decoration: none;
            color: #333;
        }
        .product-grid {
            width: 80%;
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }
        .product-card {
            width: 30%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product-card img {
            width: 100%;
            height: auto;
        }
        .product-card h3, .product-card p {
            text-align: center;
        }
        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="img/EzR Logo.png" alt="Logo" class="logo">
        <h1>EZ reborn gears</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li class="current"><a href="shop.php">Shop</a></li>
                <li><a href="schedule.php">Events</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="../LogReg/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="shop-container">
            <aside class="categories">
                <h2>Categories</h2>
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a href="shop.php?category=<?php echo urlencode($category); ?>" <?php echo $category === $selected_category ? 'style="font-weight: bold;"' : ''; ?>>
                                <?php echo htmlspecialchars($category); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
            <section class="product-grid">
                <form class="search-bar" action="shop.php" method="get">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($selected_category); ?>">
                    <input type="text" name="search" placeholder="Search for products..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Search</button>
                </form>
                <?php if (empty($filtered_products)) : ?>
                    <p>No products found in this category.</p>
                <?php else : ?>
                    <?php foreach ($filtered_products as $product_id => $product) : ?>
                        <div class="product-card">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>₱<?php echo number_format($product['price'], 2); ?></p>
                            <form action="shop.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <input type="number" name="quantity" value="1" min="1" max="10">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
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
