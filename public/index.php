<?php
require_once __DIR__ . '/../src/config/config_session.php';
require_once __DIR__ . '/../src/includes/dbh.inc.php';
require_once __DIR__ . '/../src/models/user_model.php';
require_once __DIR__ . '/../src/models/artwork_model.php';

// Routing
$requestPath = isset($_GET['url']) ? $_GET['url'] : '/';

switch ($requestPath) {
  case 'artworks':
    break;
  case 'artists':
    break;
  case 'about':
    break;
  case 'shop':
    require __DIR__ . '/../src/controllers/compre.php';
    handleShopRequest();
    break;
  case 'product':
    require __DIR__ . '/../src/controllers/product.php';
    handleProductRequest();
    break;
  case 'cart':
    require __DIR__ . '/../src/controllers/basket.php';
    handleBasketRequest();
    break;
  case 'checkout':
    require __DIR__ . '/../src/includes/checkout_contr.inc.php';
    require __DIR__ . '/../src/controllers/checkout.php';
    handleCheckoutRequest();
    break;
  case 'signin':
    require __DIR__ . '/../src/includes/signin_contr.inc.php';
    require __DIR__ . '/../src/controllers/signin.php';
    handleSigninRequest();
    break;
  case 'signup':
    require __DIR__ . '/../src/includes/signup_error_handler.php';
    require __DIR__ . '/../src/controllers/signup.php';
    handleSignupRequest();
    break;
  case 'signout':
    require __DIR__ . '/../src/controllers/signout.php';
    handleSignoutRequest();
    break;
  case 'account':
    require __DIR__ . '/../src/controllers/account.php';
    handleAccountRequest();
    break;
  case 'profile':
    break;
  case 'admin':
  case 'admin/product':
    require __DIR__ . '/../src/controllers/admin.php';
    handleAdminRequest();
    break;
  case '/':
    include __DIR__ . '/../src/views/home.php';
    break;
  default:
    http_response_code(404);
    echo 'Page not found';
    break;
}
