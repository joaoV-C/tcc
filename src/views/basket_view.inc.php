<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <?php include 'includes/header.inc.php'; ?>

  <div class="general-content-container cart-container">

    <h1 class="page-h1">Seu cesto</h1>

    <?php if (!empty($cartErrors)): ?>
      <div class="alert alert-error">
        <?= htmlspecialchars($cartErrors['user_unsigned'] ?? ''); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
      <div class="table-container cart-table-container">
        <table class="table cart-table">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $subtotal = 0;

            foreach ($_SESSION['cart'] as $item):
              $itemSubtotal = $item['price'] * $item['quantity'];
              $subtotal += $itemSubtotal;

              $_SESSION['item_id'] = $item['id'];
              $_SESSION['item_image'] = $item['image'];
              $_SESSION['item_qty'] = $item['quantity'];
            ?>
              <tr>
                <td>
                  <img src="public/assets/images/<?= htmlspecialchars($item['image']) ?>"
                    class="product-image"
                    alt="<?= htmlspecialchars($item['name']) ?>">

                  <?= htmlspecialchars($item['name']) ?>
                </td>
                <td>
                  <div class="qty-column">

                    <form method="post">
                      <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($item['id']) ?>">
                      <input type="hidden" name="action" value="subtract">
                      <button type="submit" class="btn add-subtract-btn">-</button>
                    </form>

                    <span><?= htmlspecialchars($item['quantity']) ?></span>

                    <form method="post">
                      <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($item['id']) ?>">
                      <input type="hidden" name="action" value="add">
                      <button type="submit" class="btn add-subtract-btn">+</button>
                    </form>

                  </div>
                </td>
                <td>€<?= number_format($item['price'], 2) ?></td>
                <td>€<?= number_format($itemSubtotal, 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="summary cart-summary">
        <h3>Resumo do Pedido</h3>

        <p>Subtotal: €<?= number_format($subtotal, 2) ?></p>
        <p>IVA: €<?= number_format($subtotal * 0.23, 2) ?></p>
        <hr>
        <h4>Total: €<?= number_format($subtotal * 1.23, 2) ?></h4>

        <?php if (!isset($_SESSION['user_id'])): ?>
          <form action="/tcc/cart" method="post">
            <input type="hidden" name="user_session" value="isUnset">

            <button type="submit" class="btn session-check-btn checkout-redirector-btn">Finalizar compra</button>
          </form>
        <?php else: ?>
          <form action="/tcc/checkout" method="post">
            <input type="hidden" name="qty" value="<?= htmlspecialchars($_SESSION['item_qty']) ?>">
            <input type="hidden" name="subtotal" value="<?= number_format($subtotal, 2) ?>">
            <input type="hidden" name="tax" value="<?= number_format($subtotal * 0.23, 2) ?>">
            <input type="hidden" name="total" value="<?= number_format($subtotal * 1.23, 2) ?>">

            <button type="submit" class="btn checkout-redirector-btn">Finalizar compra</button>
          </form>
        <?php endif; ?>
      </div>

      <a href="/tcc/shop" class="link store-link">Continue Comprando</a>

    <?php else: ?>
      <p class="empty-cart-message">Seu cesto está vazio. <a href="/tcc/shop">Continue Comprando</a></p>
    <?php endif ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
      <form action="/tcc/signin" method="get" class="form signin-redirector-form">
        <button type="submit" class="btn signin-redirector-btn">Iniciar sessão</button>
      </form>
    <?php endif ?>
  </div>
</body>

</html>