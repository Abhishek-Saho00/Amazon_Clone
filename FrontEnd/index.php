<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Amazon cloning</title>
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js" defer></script>
  </head>


  <body>
    <header>
      <div class="navbar">
        <div class="nav-logo">
          <div class="logo"></div>
        </div>
        <div class="nav-address border">
          <p class="add-first">Deliver to</p>
          <div class="add-icon">
            <i class="material-icons">location_on</i>
            <p class="add-second">Nepal</p>
          </div>
        </div>

        <form action="index.php" method="GET" class="nav-search" role="search">
          <select class="search-select" aria-label="Product category">
            <option value="">All</option>
          </select>

          <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search Amazon"
            aria-label="Search products"
            value="<?php if(isset($_GET['search'])) echo htmlspecialchars($_GET['search']); ?>"
          >

          <button type="submit" class="search-icon" aria-label="Search">
            <i class="material-icons">search</i>
          </button>
        </form>


        <div class="nav-signin border" style="text-decoration:none; color:white;" role="button" tabindex="0">
          <?php if(isset($_SESSION['username'])): ?>
            <p><span>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
            <p class="nav-second"><a href="/Amazon_webSite/BackEnd/logout.php" style="color:white; text-decoration:none;" onclick="event.preventDefault(); fetch('/Amazon_webSite/BackEnd/logout.php', {credentials:'same-origin'}).then(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; }).catch(()=>{ window.location='/Amazon_webSite/FrontEnd/auth.php'; });">Logout</a></p>
          <?php else: ?>
            <a href="auth.php" style="text-decoration:none; color:white;">
              <p><span>Hello, Sign in</span></p>
              <p class="nav-second">Account & Lists</p>
            </a>
          <?php endif; ?>
        </div>


        <div class="nav-return border">
          <p><span>Return</span></p>
          <p class="nav-second">& Orders</p>
        </div>

        <div class="nav-cart border" role="button" tabindex="0" onclick="document.getElementById('cart-box').style.display='block';" style="cursor:pointer;" aria-label="View shopping cart">
          <i class="material-icons">shopping_cart</i>
          <span>Cart</span>
          <span class="cart-badge" id="cart-count">0</span>
        </div>



      </div>

      <nav class="panel">
        <div class="panel-all">
          <i class="material-icons">menu</i>
          <p>All</p>
        </div>
        <div class="panel-ops">
          <p>Today's Deals</p>
          <p>Customer Service</p>
          <p>Registry</p>
          <p>Sell</p>
        </div>

        <div class="panel-deal">🎯 Shop deals in Electronics</div>
      </nav>
    </header>

    <!-- Cart box: shows cart items when user clicks cart -->
    <div id="cart-box" style="display:none; position:fixed; right:20px; top:80px; width:340px; max-height:70vh; overflow:auto; background:#fff; border:1px solid #ddd; border-radius:6px; box-shadow:0 6px 20px rgba(0,0,0,0.12); z-index:10000; padding:12px;">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
        <h3 style="margin:0; font-size:16px;">🛒 Shopping Cart</h3>
        <button onclick="document.getElementById('cart-box').style.display='none';" style="background:transparent;border:none;cursor:pointer;font-size:18px;">✖</button>
      </div>
      <div id="cart-contents" style="margin-top:10px;">
        <!-- Filled by JS -->
      </div>
      <div style="display:flex; justify-content:space-between; gap:8px; margin-top:12px;">
        <button onclick="clearCart()" style="flex:1; background:#f0f0f0; border:1px solid #ddd; padding:8px; border-radius:4px; cursor:pointer;">Clear</button>
        <button onclick="checkout()" style="flex:1; background:#FF9900; color:#fff; border:none; padding:8px; border-radius:4px; cursor:pointer;">Checkout</button>
      </div>
    </div>

    <div class="hero-section">
      <div class="hero-message">
        <p>
          You are on amazon.com. You can also shop on <strong>Amazon</strong> for millions of products with fast local delivery.
          <a href="#" style="color: white; text-decoration: underline;"> Shop Now →</a>
        </p>
      </div>
      
      <!-- Carousel Indicator Dots -->
      <div class="carousel-indicators">
        <button class="carousel-indicator active" onclick="heroCarousel.goToImage(0)" aria-label="Slide 1"></button>
        <button class="carousel-indicator" onclick="heroCarousel.goToImage(1)" aria-label="Slide 2"></button>
        <button class="carousel-indicator" onclick="heroCarousel.goToImage(2)" aria-label="Slide 3"></button>
        <button class="carousel-indicator" onclick="heroCarousel.goToImage(3)" aria-label="Slide 4"></button>
        <button class="carousel-indicator" onclick="heroCarousel.goToImage(4)" aria-label="Slide 5"></button>
      </div>
    </div>


    <div class="shop-section">
<?php
include '../BackEnd/db.php';

$search = "";

if(isset($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
}

$sql = "SELECT * FROM products WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";

$result = $conn->query($sql);

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
?>
      <div class="box" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-name="<?php echo htmlspecialchars($row['name']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" data-image="<?php echo htmlspecialchars($row['image']); ?>">
        <div class="box-content">
          <!-- Product Image -->
          <div class="box-image" style="background-image:url('images/<?php echo htmlspecialchars($row['image']); ?>')"></div>
          
          <!-- Product Name -->
          <h3 class="product-title"><?php echo htmlspecialchars($row['name']); ?></h3>

          <!-- Price and Action -->
          <div class="box-footer">
            <span class="price">₹<?php echo htmlspecialchars($row['price']); ?></span>
            <span class="see-more">See more</span>
          </div>

          <!-- Add to Cart Button -->
          <button class="add-btn" aria-label="Add <?php echo htmlspecialchars($row['name']); ?> to cart">Add to Cart</button>
        </div>
      </div>
<?php
    }
} else {
    // Show different message if search was done vs empty database
    if (empty($search)) {
        echo "<div class='no-results'><h2>No products available</h2><p>Please check back soon!</p></div>";
    } else {
        echo "<div class='no-results'><h2>Item not found</h2><p>Try searching for something else</p></div>";
    }
}
?>
    </div>

    <footer>
      <div class="foot-panel">Back to Top</div>
      
      <div class="foot-panel2">
        <ul>
          <p><strong>Get to Know Us</strong></p>
          <a href="#">Careers</a>
          <a href="#">Blog</a>
          <a href="#">About Amazon</a>
          <a href="#">Investor Relations</a>
          <a href="#">Amazon Devices</a>
          <a href="#">Amazon Science</a>
        </ul>

        <ul>
          <p><strong>Make Money with Us</strong></p>
          <a href="#">Sell products on Amazon</a>
          <a href="#">Sell on Amazon Business</a>
          <a href="#">Sell apps on Amazon</a>
          <a href="#">Become an Affiliate</a>
          <a href="#">Advertise Your Products</a>
          <a href="#">Self-Publish with Us</a>
          <a href="#">Host an Amazon Hub</a>
        </ul>

        <ul>
          <p><strong>Amazon Payment Products</strong></p>
          <a href="#">Amazon Business Card</a>
          <a href="#">Shop with Points</a>
          <a href="#">Reload Your Balance</a>
          <a href="#">Amazon Currency Converter</a>
        </ul>

        <ul>
          <p><strong>Let Us Help You</strong></p>
          <a href="#">Your Account</a>
          <a href="#">Return Centre</a>
          <a href="#">Where's My Stuff?</a>
          <a href="#">100% Purchase Protection</a>
          <a href="#">Help</a>
        </ul>
      </div>

      <div class="foot-panel3">
        <div class="logo"></div>
      </div>

      <div class="foot-panel4">
        <div class="pages">
          <a href="#">Conditions of Use & Sale</a>
          <a href="#">Privacy Notice</a>
          <a href="#">Your Ads Privacy Choices</a>
        </div>
        <div class="copyright">
          © 1996-2026, Amazon.com, Inc. or its affiliates
        </div>
      </div>
    </footer>
  </body>
</html>
