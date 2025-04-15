<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>checkout</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <link rel="stylesheet" href="node_modules\intl-tel-input\build\css\intlTelInput.css">
  <style>
    .checkout.container form {
      width: 30%;
    }

    .checkout.form-content {
      display: flex;
      flex-direction: column;

    }

    .form-input.container {
      display: flex;
      flex-direction: column;
      padding-top: 20px;
    }

    .input.text-box {
      width: 100%;
      height: 30px;
      padding: 8px;
      font-size: 1rem;
    }

    .checkout.form-content p {
      margin-top: 10px;
    }

    #address-contraction {
      display: flex;
      gap: 10px;
    }

    .contraction-inputs {
      display: flex;
      flex-direction: column;
    }

    .contraction-inputs input {
      width: 100%;
    }
  </style>
</head>

<body>
  <?php include 'includes/header.inc.php'; ?>

  <?php if (!isset($_SESSION['user_id'])) : ?>

    <div class="checkout error-message">
      <p><?= htmlspecialchars($checkoutErrors['expired_session'] ?? '') ?></p>
    </div>
    <form action="/tcc/signin" method="get">
      <button type="submit" class="checkout btn">Inciar sessão</button>
    </form>

  <?php elseif (!empty($checkoutSuccess)): ?>

    <div class="checkout success-message">
      <?= htmlspecialchars($checkoutSuccess) ?>
    </div>
    <form action="/tcc/shop" method="get">
      <button type="submit" class="checkout btn">Continue comprando</button>
    </form>

  <?php else: ?>

    <div class="checkout container">
      <form action="/tcc/checkout" method="post">
        <div class="checkout form-content">

          <h3 class="form h3">Endereço de entrega</h3>


          <div class="form-input container" id="country">
            <p>País/Região*</p>
            <input type="text" name="country" class="input text-box"
              value="<?= htmlspecialchars($checkoutData['country'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['country'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
            <?php endif; ?>
          </div>

          <div class="form-input container" id="personal-info">
            <p>Nome completo*</p>
            <input type="text" name="full_name" class="input text-box" placeholder="Nome e sobrenome"
              value="<?= htmlspecialchars($checkoutData['full_name'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['full_name'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
            <?php endif; ?>

            <p>Telefone*</p>
            <input type="text" name="phone_number" class="input text-box" id="phone" placeholder="Ex.: +351 123-456-789"
              value="<?= htmlspecialchars($checkoutData['phone_number'] ?? ''); ?>">

            <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['phone_number'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>

            <?php elseif (!empty($checkoutErrors['invalid_number']) && !empty($checkoutData['phone_number'])): ?>
              <span class="error-message"><?php echo $checkoutErrors['invalid_number']; ?></span>
            <?php endif; ?>
          </div>

          <div class="form-input container" id="shipping-address">
            <p>Endereço*</p>
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
                <p>Cidade*</p>
                <input type="text" name="city" class="input text-box" value="<?= htmlspecialchars($checkoutData['city'] ?? ''); ?>">
                <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['city'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
                <?php endif; ?>
              </span>

              <span class="contraction-inputs">
                <p>Distrito/Estado*</p>
                <input type="text" name="district" class="input text-box" value="<?= htmlspecialchars($checkoutData['district'] ?? ''); ?>">
                <?php if (!empty($checkoutErrors['empty_input']) && empty($checkoutData['district'])): ?>
                  <span class="error-message"><?php echo $checkoutErrors['empty_input']; ?></span>
                <?php endif; ?>
              </span>

              <span class="contraction-inputs">
                <p>Código postal*</p>
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
          <button type="submit" class="checkout btn">Continuar</button>
        </div>
      </form>

      <div class="summary">
        <h3>Resumo do Pedido</h3>

        <?php
        foreach ($_SESSION['cart'] as $item):
        ?>
          <img src="public/assets/images/<?= htmlspecialchars($item['image'] ?? '') ?>"
            class="product-image"
            alt="<?= htmlspecialchars($item['name'] ?? '') ?>">

          <?= htmlspecialchars($item['name'] ?? '') ?>

          <p>Quantidade: <?= htmlspecialchars($item['quantity'] ?? '') ?></p>
        <?php endforeach; ?>

        <p>Subtotal: €<?= htmlspecialchars($checkoutSummary['subtotal'] ?? '') ?></p>
        <p>IVA: €<?= htmlspecialchars($checkoutSummary['tax'] ?? '') ?></p>
        <hr>
        <h4>Total: €<?= htmlspecialchars($checkoutSummary['total'] ?? '') ?></h4>
      </div>
    </div>
  <?php endif; ?>

  <script src="node_modules\intl-tel-input\build\js\intlTelInput.js"></script>
  <script>
    const input = document.querySelector("#phone");
    window.intlTelInput(input, {
      loadUtils: () => import("https://my-domain/node_modules\intl-tel-input\build\js/utils.js"),
    });
  </script>
</body>

</html>