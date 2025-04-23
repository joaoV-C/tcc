<?php
require_once __DIR__ . '/../models/user_model.php';

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
    return !password_verify($password, $this->userModel->findByEmail($email)['pwd']);
  }
}
