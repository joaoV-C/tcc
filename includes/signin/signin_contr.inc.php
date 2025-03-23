<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Location: ../../signin.php');
}

require_once 'includes/user_model.inc.php';

$userModel = new UserModel($pdo);
class SigninErrorHandler {
  private $userModel;

  public function __construct(UserModel $userModel) {
    $this->userModel = $userModel;
  }

  public function isEmailUnsigned(string $email): bool {
    return (bool) !isset($this->userModel->findByEmail($email)['email']);
  }

  public function isPasswordWrong(string $password, string $email): bool {
    return !password_verify($password, $this->userModel->findUserByEmail($email)['pwd']);
  }
}
