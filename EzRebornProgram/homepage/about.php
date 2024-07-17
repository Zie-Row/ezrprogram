<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - EZReborn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="img/EzR Logo.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li class="current"><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="about">
            <div class="about-content">
                <h1>About EZReborn E-Sports</h1>
                <p>Welcome to EZReborn E-Sports, your ultimate destination for high-quality gaming products and accessories. We are passionate about providing gamers with the best tools and gear to enhance their gaming experience.</p>
                <p>At EZReborn, we understand the importance of performance and reliability in gaming equipment. That's why we carefully select and offer a curated collection of products ranging from gaming peripherals to gaming PCs, ensuring that every gamer finds what they need to succeed.</p>
                <p>Our mission is to support the gaming community by providing top-notch customer service and delivering products that meet the highest standards of quality and innovation.</p>
                <p>Thank you for choosing EZReborn E-Sports. Game on!</p>
            </div>
            <div class="about-image">
                <img src="img/about.jpg" alt="About EZReborn">
            </div>
        </section>
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
