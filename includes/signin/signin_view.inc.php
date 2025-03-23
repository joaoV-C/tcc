<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <?php include('includes/header.inc.php'); ?>

  <div class="signin-container">

    <form method="post">

      <div class="signin-content">

        <h2>Inicie sessão</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
          <h3><?php echo $signinSuccess ?></h3>
        <?php endif ?>

        <div class="signin-input email">
          <input type="text" name="email" placeholder="Email" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['email'] ?? ''); ?>">

          <div class="form-message-wrapper">
            <?php if (!empty($signinErrors['unsigned_email'])): ?>
              <p class="error"><?php echo $signinErrors['unsigned_email']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div class="signin-input password">
          <input type="password" name="password" placeholder="Palavra-passe" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['password'] ?? ''); ?>">

          <div class="form-message-wrapper">
            <?php if (!empty($signinErrors['wrong_password'])): ?>
              <p class="error"><?php echo $signinErrors['wrong_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <button type="submit">Continuar</button>

      </div>
    </form>
  </div>
  <div>
    <a href="signup.php">Criar conta</a>
  </div>
</body>

</html>