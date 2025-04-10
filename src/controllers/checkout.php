<?php
require_once 'src/config/config_session.php';
require_once 'includes/dbh.inc.php';
require_once '/src/models/user_model.php';
require_once 'includes/checkout/checkout_contr.inc.php';

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subtotal'], $_POST['tax'], $_POST['total'])) {
    $_SESSION['cart_summary'] = [
      'subtotal' => $_POST['subtotal'],
      'tax' => $_POST['tax'],
      'total' => $_POST['total']
    ];
  } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'], $_SESSION['cart'])) {
    $userModel = new UserModel($pdo);
    $checkoutErrorHandler = new CheckoutErrorHandler;

    $country = $_POST['country'] ?? '';
    $fullName = $_POST['full_name'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $complement = $_POST['complement'] ?? '';
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $postalCode = $_POST['postal_code'] ?? '';

    $errors = [];

    if ($checkoutErrorHandler->isInputEmpty($country, $fullName, $phoneNumber, $address, $city, $district, $postalCode)) {
      $errors['empty_input'] = 'Preencha todos os campos obrigatórios';
    }

    $phoneNumberPattern = '/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?([0-9]{3}[-\s\.]?){3}$/';
    if (!preg_match($phoneNumberPattern, $phoneNumber)) { // phone number input validation
      $errors['invalid_number'] = 'Introduza um número de telefone válido';
    }

    $postalCodePattern = '/^(\d{4}-\d{3}|(\d{4}[ -]?\d{3})|\d{4}|\d{5}|[A-Z]\d{1,2}[A-Z]? \d[A-Z]{2}|\d{4} [A-Z]{2})$/i';
    if (!preg_match($postalCodePattern, $postalCode)) { // phone number input validation
      $errors['invalid_postal_code'] = 'Introduza um código postal válido';
    }

    if (!empty($errors)) {
      $_SESSION['checkout_errors'] = $errors;
      $_SESSION['checkout_data'] = [
        'country' => $country,
        'full_name' => $fullName,
        'phone_number' => $phoneNumber,
        'address' => $address,
        'complement' => $complement,
        'city' => $city,
        'district' => $district,
        'postal_code' => $postalCode
      ];

      header('Location: checkout.php?compra=falha');
      exit();
    } else {
      if (isset($_SESSION['user_id'])) {
        $orderId = $userModel->createOrder(
          $_SESSION['user_id'],
          $_SESSION['user_email'],
          $country,
          $fullName,
          $phoneNumber,
          $address,
          $complement,
          $city,
          $district,
          $postalCode,
          $_SESSION['cart_summary']['total'],
          $_SESSION['cart']
        );
        unset($_SESSION['cart']);

        $_SESSION['checkout_success'] = 'Compra efetuada com sucesso. Número do pedido: ' . $orderId;

        header('Location: checkout.php?compra=sucesso');
        exit();
      } else {
        $_SESSION['checkout_errors']['expired_session'] = 'Sessão expirada';

        header('Location: checkout.php?compra=falha');
        exit();
      }
    }
  }
} catch (PDOException $e) {
  $_SESSION['checkout_errors'] = ("Falha no envio: " . $e->getMessage());
  throw $e;
  header("Location: checkout.php?erro");
  exit();
}

$checkoutErrors = $_SESSION['checkout_errors'] ?? '';
$checkoutSuccess = $_SESSION['checkout_success'] ?? '';
$checkoutData = $_SESSION['checkout_data'] ?? '';
$checkoutSummary = $_SESSION['cart_summary'] ?? '';
unset($_SESSION['checkout_errors'], $_SESSION['checkout_success'], $_SESSION['checkout_data']);

include 'includes/checkout/checkout_view.inc.php';
