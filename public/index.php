<?php
require_once __DIR__ . '/../src/config/config_session.php';
require_once __DIR__ . '/../src/includes/dbh.inc.php';

// Routing
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

switch ($path) {
  case '/signin':
  case '/signin.php':
    require __DIR__ . '/../src/controllers/signin.php';
    handleSigninRequest();
    break;
  case 'signup':
    require __DIR__ . '/../src/controllers/signup.php';
    handleSignupRequest();
    break;
  default:
    http_response_code(404);
    echo  'Page not found';
    break;
}
