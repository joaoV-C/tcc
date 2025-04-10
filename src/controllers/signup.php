<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/user_model.inc.php';
require_once 'includes/signup/signup_contr.inc.php';
require_once 'src/config/config_session.php';

try {
  $userModel = new UserModel($pdo);
  $signupErrorHandler = new SignupErrorHandler($userModel);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['repeat_password'] ?? '';

    $errors = [];

    if ($signupErrorHandler->isInputEmpty($username, $email, $password)) {
      $errors['empty_input'] = 'Preencha todos os campos';
    }
    if ($signupErrorHandler->isEmailInvalid($email)) {
      $errors['invalid_email'] = 'Introduza um email válido';
    }
    if ($signupErrorHandler->isEmailRegistered($email)) {
      $errors['registered_email'] = 'Este endereço de email já está em uso';
    }
    if ($signupErrorHandler->isPasswordWeak($password)) {
      $errors['weak_password'] = 'É obrigatório ter, no mínimo, 8 carateres';
    }
    if ($signupErrorHandler->isPasswordUnmatching($password, $repeatPassword)) {
      $errors['unmatching_password'] = 'As palavras-passe têm de corresponder';
    }

    if (!empty($errors)) { // Falha
      $_SESSION['signup_errors'] = $errors;
      $_SESSION['signup_data'] = [
        'username' => $username,
        'email' => $email,
        'password' => $password
      ];

      header('Location: /signup.php?registo=falha');
      exit();
    } else { // Sucesso
      $userModel->createUser($username, $email, $password);
      $_SESSION['signup_success'] = "Registo feito com sucesso";
      header("Location: /signup.php?registo=sucesso");
      exit();
    }
  }
} catch (PDOException $e) {
  $_SESSION['signup_errors'] = ("Falha na consulta: " . $e->getMessage());
  header("Location: /signup.php");
  exit();
}

$signupErrors = $_SESSION['signup_errors'] ?? '';
$signupSuccess =  $_SESSION['signup_success'] ?? '';
$signupData = $_SESSION['signup_data'] ?? '';
unset($_SESSION['signup_errors'], $_SESSION['signup_success'], $_SESSION['signup_data']);


include 'includes/signup/signup_view.inc.php';

/*
try {
  $userModel = new UserModel($pdo);
  $signupErrorHandler = new SignupErrorHandler($userModel);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel->createUser(
      $_POST['username'],
      $_POST['email'],
      $_POST['password']
    );

    if ($signupErrorHandler->isInputEmpty($_POST['username'], $_POST['email'], $_POST['password'])) {
      echo ('There is an input fild missing');
    }

    if ($signupErrorHandler->isUsernameTaken($_POST['username'])) {
      log('Este nome de usuário já existe');
    }

    $_SESSION['success'] = "Registo feito com sucesso!";
    header("Location: login_reg.php?registo=sucesso");
    log('sucesso');
    exit();
  }
} catch (PDOException $e) {
  throw new RuntimeException("Erro na base de dados: " . $e->getMessage());
  header("Location: login_reg.php");
  exit();
}
*/