<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZReborn Home Page</title>
    <link rel="stylesheet" href="style.css">
    <!-- Add CSS for sliders if needed -->
    <style>
        /* Example styles for slider */
        .slider {
            width: 100%;
            overflow: hidden;
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease;
        }
        .slide {
            min-width: 100%;
            flex: 0 0 auto;
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
                <li><a href="cart.php">Cart</a></li>
                <li><a href="../LogReg/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="welcome">
            
            <p>Discover the best products for your gaming needs.</p>
        </section>

        <section class="featured-products">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <!-- Example Product -->
                <div class="product-card">
                    <img src="img/product1.jpg" alt="Product 1">
                    <h3>Product 1</h3>
                    <p>Php200.99</p>
                    <button>Add to Cart</button>
                </div>
                <!-- Add more product cards as needed -->
            </div>
        </section>

        <section class="news">
            <h2>E-Sports News</h2>
            <div class="slider">
                <div class="slides">
                    <div class="slide">
                        
                        <h3>Latest Tournament Results</h3>
                        <p>EZR 1-0 NXP</p>
                    </div>
                    <div class="slide">
                        
                        <h3>New Honor Of Kings Tournament</h3>
                        <p>sign up for HOK in our e-sports</p>
                    </div>
                    
                </div>
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
   
    <script>
        
        const slides = document.querySelector('.slides');
        let slideIndex = 0;

        function showSlides() {
            const slidesWidth = slides.offsetWidth;
            slideIndex++;
            if (slideIndex >= slides.children.length) {
                slideIndex = 0;
            }
            slides.style.transform = `translateX(${-slideIndex * slidesWidth}px)`;
            setTimeout(showSlides, 3000); 
        }

        showSlides();
    </script>
</body>
</html>
