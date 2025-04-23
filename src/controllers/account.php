<?php
function handleAccountRequest(): void {

  if (!isset($_SESSION['user_id'])) {
    header("Location: /tcc/signin");
    exit();
  }

  try {
    $orders = [];
    $userModel = new UserModel($GLOBALS['pdo']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
      $orderId = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);

      if ($orderId && $userModel->cancelOrder($_SESSION['user_id'], $orderId)) {
        $_SESSION['account_success'] = 'Pedido #' . $orderId . ' cancelado com sucesso';
      } else {
        $_SESSION['account_errors'] = 'Falha ao cancelar pedido';
      }
      header("Location: /tcc/account?action=cancelar_pedido&n=$orderId");
      exit();
    }
    $orders = $userModel->getOrders($_SESSION['user_id']);
  } catch (PDOException $e) {

    $error = 'Erro na base de dados: ' . $e->getMessage();
    $_SESSION['account_errors'] = $error;
  }

  $groupedOrders = [];
  foreach ($orders as $item) {
    $orderId = $item['order_id']; // $orderId will be sent as an input and used
    // in the cancellation logic.

    if (!isset($groupedOrders[$orderId])) {
      $groupedOrders[$orderId] = [
        'order_date' => $item['order_date'],
        'total' => $item['total'],
        'items' => []
      ];
    }

    $groupedOrders[$orderId]['items'][] = $item;
  }


  include __DIR__ . '/../views/account_view.php';
}
