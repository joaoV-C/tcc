<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/user_model.inc.php';
require_once 'includes/signin/signin_contr.inc.php';
require_once 'includes/config_session.inc.php';

try {
  $userModel = new UserModel($pdo);
  $signinErrorHandler = new SigninErrorHandler($userModel);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

      header('Location: signin.php?entrar=falha');
      exit();
    } else {
      $_SESSION['signin_success'] = 'Log in efetuado com sucesso';
      $_SESSION['user_id'] = $userModel->findByEmail($email)['id'];
      $_SESSION['user_email'] = $userModel->findByEmail($email)['email'];

      header('Location: signin.php?entrar=sucesso');
      exit();
    }
  }
} catch (PDOException $e) {
  $_SESSION['signin_errors'] = ("Falha na consulta: " . $e->getMessage());
  header("Location: signin.php");
  exit();
}

$signinErrors = $_SESSION['signin_errors'] ?? '';
$signinSuccess = $_SESSION['signin_success'] ?? '';
$userEmail = $_SESSION['user_email'] ?? '';
$signinData = $_SESSION['signin_data'] ?? '';
unset($_SESSION['signin_errors'], $_SESSION['signin_success'], $_SESSION['user_email'], $_SESSION['signin_data']);


include 'includes/signin/signin_view.inc.php';
