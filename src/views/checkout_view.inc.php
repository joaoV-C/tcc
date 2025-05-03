<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>checkout</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <link rel="stylesheet" href="/tcc/public/vendor/intl-tel-input/css/intlTelInput.css">
</head>

<body>
  <?php include 'includes/header.inc.php'; ?>

  <?php if (!isset($_SESSION['user_id'])) : ?>

    <div>
      <p class="alert alert-error"><?= htmlspecialchars($checkoutErrors['expired_session'] ?? '') ?></p>
    </div>
    <form action="/tcc/signin" method="get">
      <button type="submit" class="checkout btn">Inciar sessão</button>
    </form>

  <?php elseif (!empty($checkoutSuccess)): ?>

    <div class="general-content-container">
      <div class="alert alert-success">
        <?= htmlspecialchars($checkoutSuccess) ?>
      </div>
      <form action="/tcc/shop" method="get">
        <button type="submit" class="checkout btn">Continue comprando</button>
      </form>
    </div>

  <?php else: ?>

    <div class="checkout-container general-content-container">
      <form action="/tcc/checkout" method="post">
        <div class="checkout-form-inputs">

          <h3 class="form h3">Endereço de entrega</h3>

          <div class="checkout-form-input-container" id="country">
            <p>País/Região*</p>
            <input type="text" name="country" class="input text-box"
              value="<?= htmlspecialchars($checkoutData['country'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['country'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
            <?php endif; ?>
          </div>

          <div class="checkout-form-input-container" id="personal-info">
            <p>*Nome completo</p>
            <input type="text" name="full_name" class="input text-box" placeholder="Nome e sobrenome"
              value="<?= htmlspecialchars($checkoutData['full_name'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['full_name'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
            <?php endif; ?>

            <p>*Telefone</p>
            <input type="text" name="phone_number" class="input text-box" id="phone" placeholder="Ex.: +351 123-456-789"
              value="<?= htmlspecialchars($checkoutData['phone_number'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['phone_number'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>

            <?php elseif (!empty($checkoutErrors['invalid_number']) && !empty($checkoutData['phone_number'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['invalid_number']; ?></span>
            <?php endif; ?>
          </div>

          <div class="checkout-form-input-container" id="shipping-address">
            <p>*Endereço</p>
            <input type="text" name="address" class="input text-box" placeholder="Rua, número, piso, apto, etc."
              value="<?= htmlspecialchars($checkoutData['address'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['address'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
            <?php endif; ?>

            <p>Complemento</p>
            <input type="text" name="complement" class="input text-box" placeholder="Apto, suíte, unidade, conjunto, edifício, etc."
              value="<?= htmlspecialchars($checkoutData['complement'] ?? ''); ?>">

            <div id="address-contraction">
              <span class="contraction-inputs">
                <p>*Cidade</p>
                <input type="text" name="city" class="input text-box" value="<?= htmlspecialchars($checkoutData['city'] ?? ''); ?>">
                <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['city'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
                <?php endif; ?>
              </span>

              <span class="contraction-inputs">
                <p>*Distrito/Estado</p>
                <input type="text" name="district" class="input text-box" value="<?= htmlspecialchars($checkoutData['district'] ?? ''); ?>">
                <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['district'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
                <?php endif; ?>
              </span>

              <span class="contraction-inputs">
                <p>*Código postal</p>
                <input type="text" name="postal_code" class="input text-box" value="<?= htmlspecialchars($checkoutData['postal_code'] ?? ''); ?>">
                <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['postal_code'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
                <?php elseif (!empty($checkoutErrors['invalid_postal_code']) && !empty($checkoutData['postal_code'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['invalid_postal_code']; ?></span>
                <?php endif; ?>
              </span>
            </div>
          </div>

          <input type="hidden" name="checkout" value="1">
          <button type="submit" class="btn checkout-btn">Continuar</button>

        </div>

        <div class="summary checkout-summary">
          <h3>Resumo do Pedido</h3>

          <?php foreach ($_SESSION['cart'] as $item): ?>
            <span>
              <img src="public/assets/images/<?= htmlspecialchars($item['image'] ?? '') ?>"
                class="product-image"
                alt="<?= htmlspecialchars($item['name'] ?? '') ?>">

              <?= htmlspecialchars($item['name'] ?? '') ?>
            </span>

            <p class="qty-p">Quantidade: <?= htmlspecialchars($item['quantity'] ?? '') ?></p>
          <?php endforeach; ?>

          <p>Subtotal: €<?= htmlspecialchars($checkoutSummary['subtotal'] ?? '') ?></p>
          <p>IVA: €<?= htmlspecialchars($checkoutSummary['tax'] ?? '') ?></p>
          <hr>
          <br>
          <h3>Total: €<?= htmlspecialchars($checkoutSummary['total'] ?? '') ?></h3>

        </div>
      </form>
    </div>
  <?php endif; ?>


  <script type="text/javascript" src="/tcc/public/vendor/intl-tel-input/js/intlTelInput.js"></script>
  <script type="text/javascript">
    const input = document.querySelector("#phone");
    window.intlTelInput(input, {
      loadUtils: () => import("/tcc/public/vendor/intl-tel-input/js/utils.js"),
    });
  </script>
</body>

</html>