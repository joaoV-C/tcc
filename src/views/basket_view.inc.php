<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <style>
    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }

    .cart-table th,
    .cart-table td {
      padding: 1rem;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    .summary {
      float: right;
      width: 300px;
      border: 1px solid #ddd;
      padding: 1rem;
    }

    .product-image {
      max-width: 80px;
      height: auto;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.inc.php'; ?>

  <div class="cart-container">

    <h1>Seu cesto</h1>

    <?php if (isset($cartErrors)): ?>
      <div class="cart error-message">
        <?= htmlspecialchars($cartErrors['user_unsigned'] ?? ''); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
      <table class="cart-table">
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
                    <button type="submit" class="subtract btn">-</button>
                  </form>

                  <span><?= htmlspecialchars($item['quantity']) ?></span>

                  <form method="post">
                    <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($item['id']) ?>">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="add btn">+</button>
                  </form>

                </div>
              </td>
              <td>€<?= number_format($item['price'], 2) ?></td>
              <td>€<?= number_format($itemSubtotal, 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="summary">
        <h3>Resumo do Pedido</h3>

        <p>Subtotal: €<?= number_format($subtotal, 2) ?></p>
        <p>IVA: €<?= number_format($subtotal * 0.23, 2) ?></p>
        <hr>
        <h4>Total: €<?= number_format($subtotal * 1.23, 2) ?></h4>

        <?php if (!isset($_SESSION['user_id'])): ?>
          <form action="/tcc/cart" method="post">
            <input type="hidden" name="user_session" value="unset">

            <button type="submit" class="session-check btn">Finalizar compra</button>
          </form>
        <?php else: ?>
          <form action="/tcc/checkout" method="post">
            <input type="hidden" name="qty" value="<?= htmlspecialchars($_SESSION['item_qty']) ?>">
            <input type="hidden" name="subtotal" value="<?= number_format($subtotal, 2) ?>">
            <input type="hidden" name="tax" value="<?= number_format($subtotal * 0.23, 2) ?>">
            <input type="hidden" name="total" value="<?= number_format($subtotal * 1.23, 2) ?>">

            <button type="submit" class="checkout-redirector btn">Finalizar compra</button>
          </form>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <p>Seu cesto está vazio</p>
    <?php endif ?>

    <a href="/tcc/shop">Continue Comprando</a>
  </div>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="signin-redirector-container">
      <form action="/tcc/signin" method="get">
        <button type="submit" class="signin btn">Iniciar sessão</button>
      </form>
    </div>
  <?php endif ?>
</body>

</html>