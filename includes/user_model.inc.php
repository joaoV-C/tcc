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

  public function createOrder(
    int $userId,
    string $email,
    string $country,
    string $fullName,
    string $phoneNumber,
    string $address,
    string $complement,
    string $city,
    string $district,
    string $postalCode,
    float $total,
    array $cartItems
  ): int {
    $this->pdo->beginTransaction();

    try {
      $stmt = $this->pdo->prepare( // Order header
        "INSERT INTO orders 
        (user_id, email, country, full_name, phone_number, street_addr, complement, 
        city, district, postal_code, total)
        VALUES 
        (:user_id, :email ,:country, :full_name, :phone_number, :addr, :complement, 
        :city, :district, :postal_code, :total)"
      );

      $stmt->execute([
        'user_id' => $userId,
        'email' => $email,
        'country' => $country,
        'full_name' => $fullName,
        'phone_number' => $phoneNumber,
        'addr' => $address,
        'complement' => $complement,
        'city' => $city,
        'district' => $district,
        'postal_code' => $postalCode,
        'total' => $total
      ]);

      $orderId = $this->pdo->lastInsertId();

      $itemStmt = $this->pdo->prepare( // Order items
        "INSERT INTO order_items
        (order_id, product_id, product_name, quantity, price)
        VALUES
        (:order_id, :product_id, :product_name, :quantity, :price)"
      );

      foreach ($cartItems as $item) {
        $itemStmt->execute([
          'order_id' => $orderId,
          'product_id' => $item['id'],
          'product_name' => $item['name'],
          'quantity' => $item['quantity'],
          'price' => $item['price'],
        ]);
      }

      $this->pdo->commit();
      return $orderId;
    } catch (PDOException $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }
}
