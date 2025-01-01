<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini-projet dev web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/project/public/css/styles.css" rel="stylesheet">
    <style>
        body {
            background-color: #27292a;
            color: #fff;
        }
        .navbar {
            background-color: #1f2122 !important;
        }
        .card {
            background-color: #1f2122;
            border: 1px solid #404244;
        }
        .form-control, .form-select {
            background-color: #27292a;
            border: 1px solid #404244;
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #27292a;
            color: #fff;
        }
        .table {
            color: #fff;
        }
        .cart-count {
            position: relative;
            top: -8px;
            right: -8px;
            padding: 2px 6px;
            border-radius: 50%;
            background-color: #dc3545;
            color: white;
            font-size: 12px;
        }
        .dropdown-menu {
            background-color: #1f2122;
            border: 1px solid #404244;
        }
        .dropdown-item {
            color: #fff;
        }
        .dropdown-item:hover {
            background-color: #27292a;
            color: #fff;
        }
        
footer p {
  text-align: center;
  padding: 30px 0px;
  color: #fff;
  font-weight: 300;
}

footer p a {
  color: #fff;
  transition: all 0.3s;
}

footer p a:hover {
  color: #ec6090;
}

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/project/public/index.php">Mini projet Dev web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="itemsDropdown" role="button" data-bs-toggle="dropdown">
                            Items
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/project/public/index.php?action=add">Add Item</a></li>
                            <li><a class="dropdown-item" href="/project/public/index.php?action=delete">Delete Item</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown">
                            Users
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/project/public/index.php?action=addUser">Add User</a></li>
                            <li><a class="dropdown-item" href="/project/public/index.php?action=deleteUser">Delete User</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown">
                            Shopping Cart <?php if (isset($cartCount) && $cartCount > 0): ?>
                            <span class="cart-count"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/project/public/index.php?action=addToCart">Add to Cart</a></li>
                            <li><a class="dropdown-item" href="/project/public/index.php?action=viewCart">View Cart</a></li>
                        </ul>
                    </li>
                </ul>
                <?php if (isset($userId)): ?>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        Select User
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($users as $user): ?>
                        <li><a class="dropdown-item <?= $user['id'] == $userId ? 'active' : '' ?>" 
                             href="/project/public/index.php?action=switchUser&user_id=<?= $user['id'] ?>">
                            <?= htmlspecialchars($user['username']) ?>
                        </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php 
        if (isset($message)) {
            echo $message;
        }
        require_once $view . '.php'; 
        ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/project/public/js/app.js"></script>
</body>
</html>