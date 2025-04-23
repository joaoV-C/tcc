<?php
require_once __DIR__ . '/../models/user_model.php';
require_once __DIR__ . '/../includes/signin_contr.inc.php';

function handleSigninRequest() {
  $userModel = new UserModel($GLOBALS['pdo']);
  $signinErrorHandler = new SigninErrorHandler($userModel);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $errors = [];

    if ($signinErrorHandler->isEmailUnsigned($email)) {
      $errors['unsigned_email'] = 'Endereço de email está incorreto ou não é válido';
    }
    if ($signinErrorHandler->isPasswordWrong($password, $email)) {
      $errors['wrong_password'] = 'Palavra-passe incorreta';
    }

    if (!empty($errors)) {
      $_SESSION['signin_errors'] = $errors;
      $_SESSION['signin_data'] = [
        'email' => $email,
        'password' => $password
      ];

      header('Location: /tcc/signin?entrar=falha');
      exit();
    } else {
      $_SESSION['signin_success'] = 'Log in efetuado com sucesso';
      $_SESSION['user_id'] = $userModel->findByEmail($email)['id'];
      $_SESSION['user_email'] = $userModel->findByEmail($email)['email'];

      header('Location: /tcc/signin?entrar=sucesso');
      exit();
    }
  }
  $signinErrors = $_SESSION['signin_errors'] ?? '';
  $signinSuccess = $_SESSION['signin_success'] ?? '';
  $userEmail = $_SESSION['user_email'] ?? '';
  $signinData = $_SESSION['signin_data'] ?? '';
  unset($_SESSION['signin_errors'], $_SESSION['signin_success'], $_SESSION['signin_data']);

  require __DIR__ . '/../views/signin_view.inc.php';
}
