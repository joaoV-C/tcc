<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="/tcc/js/index.js" async></script>
</head>

<body>
  <header>
    <div class="logo"><a href="/tcc/">"PlaceHolder"</a></div>

    <!-- Nav dropdown toggler -->
    <button class="bars-menu-btn" id="menu-dropdown-btn">
      <i class="fa-solid fa-bars"></i>
    </button>

    <nav class="navbar">
      <ul class="menu-links">
        <li><a href="#">Trabalhos</a></li>
        <li><a href="#">Artistas</a></li>
        <li><a href="#">Sobre a Loja</a></li>
        <li><a href="/tcc/shop">Compre</a></li>
        <li>
          <div class="dropdown">
            <button class="user icon-btn dropdown" id="user-dropdown-btn">
              <i class="fas fa-user"></i>
            </button>
            <div id="myDropdown" class="dropdown-content">
              <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/tcc/signin?action=login">Iniciar sessão</a>
                <a href="/tcc/signup?action=signup">Criar conta</a>
                <a href="/tcc/admin">Admin</a>
              <?php else: ?>
                <a href="/tcc/account?user=<?= htmlspecialchars($_SESSION['user_email']) ?>">Conta</a>
                <a href="/tcc/profile">Perfil</a>
                <span>
                  <a href="#" class="admin-redirector">Admin</a>

                  <form action="/tcc/admin?page=users" method="post" style="display: none;"
                    class="admin-redirector-form">
                    <input type="hidden" name="page" value="users">
                  </form>
                </span>
                <span>
                  <a href="#" class="logout-redirector">Logout</a>

                  <form action="/tcc/signout" method="post" style="display: none"
                    class="logout-redirector-form">
                    <input type="hidden" name="action_token" value="123">
                  </form>
                </span>
              <?php endif ?>
            </div>
          </div>
        </li>
        <li>

          <form action="/tcc/cart" method="post">
            <button class="btn cart-icon-btn">
              <p class="cart-text">Cesto</p>
              <i class="fa-solid fa-bag-shopping"></i>
            </button>
          </form>

        </li>
      </ul>
    </nav>

  </header>

</body>

</html>