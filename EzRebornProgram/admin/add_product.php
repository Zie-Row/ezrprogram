<?php
session_start();
include('database.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["product_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
$check = getimagesize($_FILES["product_image"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size (50MB limit)
if ($_FILES["product_image"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // Check if uploads directory exists and create it if not
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        echo "The file ". basename($_FILES["product_image"]["name"]). " has been uploaded.";

        // Get form data
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['product_quantity'];
        $product_discount = isset($_POST['product_discount']) ? $_POST['product_discount'] : 0;

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO product (name, price, quantity, discount, imagePath) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("sdiss", $product_name, $product_price, $product_quantity, $product_discount, $target_file); // Corrected bind_param types and parameters

            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
