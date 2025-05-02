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
  <div class="general-content-container">
    <form action="/tcc/signin" method="post" class="form signin-form">
      <div class="signin-content">
        <h1 class="page-h1">Inicie sessão</h1>

        <?php if (!empty($signinSuccess)): ?>
          <h3 class="alert alert-success success-message"><?php echo $signinSuccess ?></h3>
        <?php endif ?>

        <div class="container signin-input-container" id="signin-email">
          <input type="text" name="email" placeholder="Email" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['email'] ?? ''); ?>">

          <?php if (!empty($signinErrors['unsigned_email'])): ?>
            <p class="error error-message"><?php echo $signinErrors['unsigned_email']; ?></p>
          <?php endif; ?>
        </div>

        <div class="container signin-input-container" id="signin-password">
          <input type="password" name="password" placeholder="Palavra-passe" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signinData['password'] ?? ''); ?>">

          <?php if (!empty($signinErrors['wrong_password'])): ?>
            <p class="error error-message"><?php echo $signinErrors['wrong_password']; ?></p>
          <?php endif; ?>
        </div>

        <input type="hidden" name="signin" value="1">
        <button type="submit" class="btn signin-btn">Continuar</button>

        <div>
          <a href="/tcc/signup">Criar conta</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>