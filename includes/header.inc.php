<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Dropdown container */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    /* Dropdown button styling */
    .icon-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 10px;
    }

    /* Dropdown content (hidden by default) */
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    /* Show dropdown menu when active */
    .dropdown-content.show {
      display: block;
      top: 48px;
    }

    /* Change color on hover */
    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    /* Person icon styling */
    .fa-user,
    .fa-bag-shopping {
      font-size: 1rem;
      color: #333;
    }
  </style>
  <script src="public/js/index.js" async></script>
</head>

<body>
  <header>
    <div class="logo"><a href="index.php">PlaceHolder</a></div>

    <!-- Checkbox para controlar o menu no mobile -->
    <input type="checkbox" id="menu-toggle" />
    <label for="menu-toggle" class="menu-icon">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <nav>
      <ul>
        <li><a href="trabalhos.php">Trabalhos</a></li>
        <li><a href="artistas.php">Artistas</a></li>
        <li><a href="sobre.php">Sobre a Loja</a></li>
        <li><a href="compre.php">Compre</a></li>
        <li>
          <div class="dropdown">
            <button class="user icon-btn dropdown" id="user-dropdown-btn">
              <i class="fas fa-user"></i>
            </button>
            <div id="myDropdown" class="dropdown-content">
              <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="signin.php?action=login">Iniciar sessão</a>
                <a href="signup.php?action=signup">Criar conta</a>
              <?php else: ?>
                <a href="src/controllers/account.php">Conta</a>
                <a href="#profile">Perfil</a>
                <a href="#" class="logout-redirector">Logout</a>

                <form action="includes/signout.inc.php" method="post" style="display: none"
                  class="logout-redirector-form">
                  <input type="hidden" name="action_token" value="123">
                </form>
              <?php endif ?>
            </div>
          </div>
        </li>
        <li>
          <div class="cart-container">
            <button class="cart icon-btn">
              <i class="fa-solid fa-bag-shopping"></i>
            </button>
            <form action="/tcc/basket.php" method="post">

            </form>
          </div>
        </li>
      </ul>
    </nav>

  </header>

</body>

</html>