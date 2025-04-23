<?php
class UserModel {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function getAllUsers(): array {
    $stmt = $this->pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByEmail(string $email): mixed {
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
        (order_id, product_id, product_name, product_image, quantity, price)
        VALUES
        (:order_id, :product_id, :product_name, :product_image, :quantity, :price)"
      );

      foreach ($cartItems as $item) { // store images into here 
        $itemStmt->execute([
          'order_id' => $orderId,
          'product_id' => $item['id'],
          'product_name' => $item['name'],
          'product_image' => $item['image'],
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

  public function getOrders(int $userId): array {
    $stmt = $this->pdo->prepare(
      "SELECT o.order_id, o.order_date, o.total,
              oi.product_id, oi.product_name, oi.product_image, oi.quantity, oi.price
      FROM orders o
      JOIN order_items oi ON o.order_id = oi.order_id
      WHERE o.user_id = :user_id
      ORDER BY o.order_date DESC"
    );
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllOrders(): array {
    $stmt = $this->pdo->query(
      "SELECT * 
      FROM orders o
      JOIN order_items oi ON o.order_id = oi.order_id
      ORDER BY o.order_date DESC"
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function cancelOrder(int $userId, int $orderId): bool {
    $this->pdo->beginTransaction();
    try {
      // Verify order belongs to user
      $checkStmt = $this->pdo->prepare(
        "SELECT order_id FROM orders
        WHERE order_id = :order_id AND user_id = :user_id"
      );
      $checkStmt->execute(['order_id' => $orderId, 'user_id' => $userId]);

      if ($checkStmt->rowCount() === 0) {
        return false;
      }

      // Delete order items
      $deleteItems = $this->pdo->prepare(
        "DELETE FROM order_items WHERE order_id = :order_id"
      );
      $deleteItems->execute(['order_id' => $orderId]);

      // Delete order
      $deleteOrder = $this->pdo->prepare(
        "DELETE FROM orders WHERE order_id = :order_id"
      );
      $deleteOrder->execute(['order_id' => $orderId]);

      $this->pdo->commit();
      return true;
    } catch (PDOException $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }
}
