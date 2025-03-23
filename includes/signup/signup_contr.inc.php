<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Location: ../../signup.php');
}

require_once 'includes/user_model.inc.php';

$userModel = new UserModel($pdo);
class SignupErrorHandler {
  private $userModel;

  public function __construct(UserModel $userModel) {
    $this->userModel = $userModel;
  }

  public function isInputEmpty(string $username, string $email, string $password): bool {
    return empty($username) || empty($email) || empty($password);
  }

  public function isEmailInvalid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function isEmailRegistered(string $email): bool {
    return (bool) $this->userModel->findByEmail($email)['email'];
  }

  public function isPasswordWeak(string $password): bool {
    if (strlen($password) < 8) {
      return true;
    } else {
      return false;
    }
  }

  public function isPasswordUnmatching(string $password, string $repeatPassword): bool {
    if ($password !== $repeatPassword) {
      return true;
    } else return false;
  }
}
