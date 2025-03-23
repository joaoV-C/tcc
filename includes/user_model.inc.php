<?php
class UserModel {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function findByUsername(string $username) {
    $stmt = $this->pdo->prepare("SELECT username FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmail(string $email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findUserByEmail(string $email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function createUser(string $username, string $email, string $password): void {
    $stmt = $this->pdo->prepare(
      "INSERT INTO users (username, email, pwd) VALUES (:username, :email, :pwd)"
    );

    $options = ['cost' => 12];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->execute([
      'username' => $username,
      'email' => $email,
      'pwd' => $hashedPassword
    ]);
  }
}
