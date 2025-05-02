<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <?php include 'includes/header.inc.php'; ?>

  <div class="general-content-container account-container">
    <h1 class="page-h1">Histórico de pedidos</h1>

    <?php if (isset($_SESSION['account_errors'])): ?>
      <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['account_errors']) ?>
        <?php unset($_SESSION['account_errors']) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['account_success'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['account_success']) ?>
        <?php unset($_SESSION['account_success']) ?>
      </div>
    <?php endif; ?>

    <?php if (empty($groupedOrders)): ?>
      <p>Você não tem nenhum pedido. <a href="/tcc/shop">Comprar agora</a></p>
    <?php else: ?>
      <?php foreach ($groupedOrders as $orderId => $order): ?>
        <div class="order-container">
          <div class="order-header">
            <div>
              <h3>Pedido #<?= $orderId ?></h3>
              <p>Data: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
            </div>
            <div>
              <form class="cancel-form" method="POST">
                <input type="hidden" name="order_id" value="<?= $orderId ?>">
                <button type="submit" name="cancel_order"
                  class="btn btn-danger"
                  onclick="return confirm('Cancelar este pedido?')">
                  Cancelar pedido
                </button>
              </form>
            </div>
          </div>

          <table class="order-table">
            <thead>
              <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order['items'] as $item): ?>
                <tr>
                  <td>
                    <img src="public/assets/images/<?= htmlspecialchars($item['product_image']) ?>"
                      class="product-thumb"
                      alt="<?= htmlspecialchars($item['product_name']) ?>">
                    <?= htmlspecialchars($item['product_name']) ?>
                  </td>
                  <td>€<?= number_format($item['price'], 2) ?></td>
                  <td><?= $item['quantity'] ?></td>
                  <td>€<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <div class="order-total">
            <h4>Order Total: €<?= number_format($order['total'], 2) ?></h4>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>

</html>