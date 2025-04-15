<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <?php include('includes/header.inc.php'); ?>

  <div class="signin-container">
    <form action="/tcc/signin" method="post">
      <div class="signin-content">

        <h2>Inicie sessão</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="success-message container">
            <h3><?php echo $signinSuccess ?></h3>
          </div>
        <?php endif ?>

        <div class="form-input container" id="signin-email">
          <input type="text" name="email" placeholder="Email" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['email'] ?? ''); ?>">

          <div class="form-message-wrapper">
            <?php if (!empty($signinErrors['unsigned_email'])): ?>
              <p class="error-message"><?php echo $signinErrors['unsigned_email']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-input container" id="signin-password">
          <input type="password" name="password" placeholder="Palavra-passe" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['password'] ?? ''); ?>">

          <div class="form-message-wrapper">
            <?php if (!empty($signinErrors['wrong_password'])): ?>
              <p class="error-message"><?php echo $signinErrors['wrong_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <input type="hidden" name="signin" value="1">
        <button type="submit" class="signin btn">Continuar</button>
      </div>
    </form>
  </div>
  <div>
    <a href="/tcc/signup">Criar conta</a>
  </div>
</body>

</html>