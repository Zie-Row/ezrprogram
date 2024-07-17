<?php
session_start();
include('../LogReg/database.php'); 

$message = '';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_quantity = $_POST['quantity'];
    
    $insert_sql = "INSERT INTO product (name, price, quantity)
                   VALUES ('$product_name', '$product_price', '$product_quantity')";
    
    if ($conn->query($insert_sql) === TRUE) {
        $message = "Product '$product_name' added successfully!";
    } else {
        $message = "Error adding product: " . $conn->error;
    }
}

$inventory_sql = "SELECT id, name, price, quantity FROM product";
$result = $conn->query($inventory_sql);
$products = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        $message .= " No products found.";
    }
} else {
    $message .= " Error fetching products: " . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="content">
    <h1>Inventory</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td>
                        <a href="edit_products.php?id=<?php echo $product['id']; ?>" class="edit">Edit</a>
                        <form action="delete_product.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
