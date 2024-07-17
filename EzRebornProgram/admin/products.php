<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    </head>
    <body>
    <nav class="content">
        <h1>Add Product</h1>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product-name">Product Name:</label>
                <input type="text" id="product-name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product-price">Price:</label>
                <input type="number" id="product-price" name="product_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="product-discount">Discount (%):</label>
                <input type="number" id="product-discount" name="product_discount" step="0.01">
            </div>
            <div class="form-group">
                <label for="product-image">Product Image:</label>
                <input type="file" id="product-image" name="product_image" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Product</button>
            </div>
        </form>
    </nav>

    <div class="content manage-stocks">
        <h2>Manage Stocks</h2>
        <form action="manage_stock.php" method="post">
            <div class="form-group">
                <label for="product-id">Product ID:</label>
                <input type="text" id="product-id" name="product_id" required>
            </div>
            <div class="form-group">
                <label for="stock-quantity">Stock Quantity:</label>
                <input type="number" id="stock-quantity" name="stock_quantity" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Stock</button>
            </div>
        </form>
    </div>
</body>
</html>
</html>
