<?php
require_once '../app/models/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Item.php';
// Initialize User model
$userModel = new User();
$itemModel = new Item();
// Get the latest user
$latestUser = $userModel->getLatestUser();

// Debug information
var_dump($latestUser);  // Add this line to see what we're getting from the database

// Get username or set default
$username = $latestUser ? htmlspecialchars($latestUser['username']) : 'Profile';

// Debug information
echo "Username set to: " . $username;  // Add this line to see what username is being set
$items = $itemModel->getItems();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <title>mini-projet</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />

    <link rel="stylesheet" href="assets/css/index.css" />
  </head>
  <body>
    <header class="header-area header-sticky">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav class="main-nav">
              <a href="index.html" class="logo">
                <img src="assets/images/logo.png" alt="" />
              </a>

              <div class="search-input">
                <form id="search" action="#">
                  <input
                    type="text"
                    placeholder="Type Something"
                    id="searchText"
                    name="searchKeyword"
                    onkeypress="handle"
                  />
                  <i class="fa fa-search"></i>
                </form>
              </div>
             
              <ul class="nav">
        <li><a href="index.html" class="active">Home</a></li>
        <li><a href="#pop">Browse</a></li>
        <li><a href="#val">Our Value</a></li>
        <li><a href="#money">Money Converter</a></li>
        <li style="position: relative">
            <a href="javascript:void(0)" id="profile-link">
                <span id="profile" style="font-size:1rem;"><?php echo $username; ?></span>
                <img src="assets/images/profile-header.jpg" alt="" />
            </a>
            <!-- Dropdown Menu -->
            <div id="dropdown-menu" class="dropdown-menu">
                <button id="logout-btn" class="btn btn-danger">
                    Log out
                </button>
            </div>
        </li>
    </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-content">
            <div
              class="main-banner"
              style="background-image: url(assets/images/intro.png)"
            >
              <div class="row">
                <div class="col-lg-7">
                  <div class="header-text">
                    <h6>Welcome to the World of <br />Real Estate</h6>
                    <h4>
                      <em>Discover</em>
                      <span
                        id="title"
                        style="font-size: 3rem; font-family: poppins"
                        >Your Dream Home</span
                      >
                    </h4>
                    <div class="main-button">
                      <a href="browse.html">Browse Now</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="most-popular" id="pop">
              <div class="row">
                <div class="col-lg-12">
                  <div
                    class="heading-section d-flex justify-content-between align-items-center"
                  >
                    <h4 class="heading-with-arrows">
                      <em>Most Popular</em>&nbsp; Right Now
                    </h4>

                    <div class="arrows-container">
                      <span id="left" class="custom-arrow-left"><</span>
                      <span id="right" class="custom-arrow-right">></span>
                    </div>
                  </div>
                </div>

                <div class="swiper-container">
                <div class="swiper-wrapper">
    <?php foreach ($items as $item): ?>
        <div class="swiper-slide">
            <div class="card">
                <img
                    src="<?php echo htmlspecialchars($item['image_path']); ?>"
                    class="card-img-top card-img"
                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                />
                <div class="card-body">
                    <h5 class="card-title text-white">
                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                    </h5>
                    <p class="card-text text-white">
                        <mark><b>$<?php echo number_format($item['price'], 2); ?></b></mark>
                        <?php echo htmlspecialchars($item['description']); ?>
                    </p>
                    <a href="house<?php echo $item['id']; ?>.html" class="btn btn-outline-light">
                        See Details
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                </div>

                <div class="col-lg-12 mt-4">
                  <div class="main-button">
                    <a href="browse.html">Discover More Popular Homes</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="value" id="val">
              <div class="col-lg-12">
                <div class="heading-section">
                  <h4>Our value</h4>
                </div>
                <iframe
                  id="value"
                  src="components/value/value.html"
                  style="width: 100%; border: none"
                  scrolling="no"
                ></iframe>
              </div>
            </div>
            <div class="converter" id="money">
              <div class="col-lg-12">
                <div class="heading-section">
                  <h4>Money Converter</h4>
                </div>
                <iframe
                  id="currency-iframe"
                  src="components/currency/index.html"
                  style="width: 100%; border: none"
                  scrolling="no"
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <p>
              Copyright © 2024 <a href="#">Dhahri Bilel</a> ING - A2 - GL - 04
              &nbsp; All rights reserved
            </p>
          </div>
        </div>
      </div>
    </footer>

    <script>
        // Toggle dropdown menu
        document.getElementById('profile-link').addEventListener('click', function() {
            document.getElementById('dropdown-menu').classList.toggle('show');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('#profile-link') && !event.target.matches('#profile-username')) {
                var dropdown = document.getElementById('dropdown-menu');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });

        // Handle logout
        document.getElementById('logout-btn').addEventListener('click', function() {
            // Add your logout logic here
            window.location.href = 'login.html';
        });
    </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="index.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
  </body>
</html>
