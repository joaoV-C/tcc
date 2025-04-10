<?php
require_once 'src/config/config_session.php';
require_once 'includes/dbh.inc.php';
require_once '/src/models/user_model.php';


if (!isset($_SESSION['user_id'])) {
  header("Location: /signin.php");
  exit();
}

$orders = [];
try {
  $userModel = new UserModel($pdo);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $orderId = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);

    if ($orderId && $userModel->cancelOrder($_SESSION['user_id'], $orderId)) {
      $_SESSION['account_success'] = 'Pedido #$orderId cancelado com sucesso';
    } else {
      $_SESSION['account_errors'] = 'Falha ao cancelar pedido';
    }
    header("Location: account.php?action=cancelar_pedido&status=sucesso");
    exit();
  }

  $orders = $userModel->getOrders($_SESSION['user_id']);
} catch (PDOException $e) {
  $error = 'Erro na base de dados: ' . $e->getMessage();
  $_SESSION['account_errors'] = $error;
}

$groupedOrders = [];
foreach ($orders as $item) {
  $orderId = $item['order_id'];

  if (!isset($groupedOrders[$orderId])) {
    $groupedOrders[$orderId] = [
      'order_date' => $item['order_date'],
      'total' => $item['total'],
      'items' => []
    ];
  }
  $groupedOrders[$orderId]['items'][] = $item;
}


include 'src/views/account_view.php';
