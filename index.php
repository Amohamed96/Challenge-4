<?php
session_start();
$isLoggedIn = isset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBA Stats</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            
            <?php if (!$isLoggedIn): ?>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <header>
        <h1>NBA Statistics Hub</h1>
        <img src="hero.jpg" alt="NBA players in action" class="banner">
        <p>Your ultimate source for NBA player and team statistics.</p>
        <a href="info.html" class="button">Explore Stats</a>
    </header>

    <section class="shopping-cart">
        <h2>NBA Gear Shopping Cart</h2>
        <div class="cart-items">
            <div class="item">
                <p>NBA Jersey</p>
                <div class="buttons">
                    <button onclick="addToCart('NBA Jersey')">Add</button>
                    <button onclick="removeFromCart('NBA Jersey')">Remove</button>
                </div>
            </div>
            <div class="item">
                <p>Basketball</p>
                <div class="buttons">
                    <button onclick="addToCart('Basketball')">Add</button>
                    <button onclick="removeFromCart('Basketball')">Remove</button>
                </div>
            </div>
            <div class="item">
                <p>NBA Cap</p>
                <div class="buttons">
                    <button onclick="addToCart('NBA Cap')">Add</button>
                    <button onclick="removeFromCart('NBA Cap')">Remove</button>
                </div>
            </div>
        </div>

        <h3>Cart:</h3>
        <ul id="cart-list" class="cart-list"></ul>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            loadCart();
        });

        function addToCart(item) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (!cart.includes(item)) {
                cart.push(item);
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartDisplay();
            }
        }

        function removeFromCart(item) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart = cart.filter(cartItem => cartItem !== item);
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartDisplay();
        }

        function updateCartDisplay() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let cartList = document.getElementById("cart-list");
            cartList.innerHTML = "";

            cart.forEach(item => {
                let li = document.createElement("li");
                li.textContent = item;

                // Add remove button inside cart list
                let removeBtn = document.createElement("button");
                removeBtn.textContent = "X";
                removeBtn.onclick = () => removeFromCart(item);

                li.appendChild(removeBtn);
                cartList.appendChild(li);
            });
        }

        function loadCart() {
            updateCartDisplay();
        }
    </script>
</body>
</html>
