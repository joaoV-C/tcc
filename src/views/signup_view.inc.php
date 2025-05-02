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

  <div class="signup-container general-content-container">
    <form action="/tcc/signup" method="POST">
      <div class="signup-content">

        <h1 class="page-h1">Criar Conta</h1>

        <?php if (!empty($signupSuccess)): ?>
          <div class="success_message">
            <!-- REGISTRATION SUCCESS MESSAGE -->
            <h3><?php echo $signupSuccess; ?></h3>
          </div>
        <?php endif; ?>

        <!-- USERNAME -->
        <div class="form-input container" id="signup-username">
          <p>Digite o seu nome</p>
          <input type="text" name="username" placeholder="Nome" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['username'] ?? ''); ?>">

          <!-- USERNAME REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (!empty($signupErrors['empty_input']) && empty($signupData['username'])): ?>
              <p class="error-message"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- EMAIL -->
        <div class="form-input container" id="signup-email">
          <p>Email</p>
          <input type="email" name="email" placeholder="nome@example.com" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['email'] ?? ''); ?>">

          <!-- EMAIL REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input']) && empty($signupData['email'])): ?>
              <p class="error-message"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif ?>
            <?php if (isset($signupErrors['invalid_email'])): ?>
              <p class="error-message"><?php echo $signupErrors['invalid_email']; ?></p>
            <?php endif ?>
            <?php if (isset($signupErrors['registered_email'])): ?>
              <p class="error-message"><?php echo $signupErrors['registered_email']; ?></p>
            <?php endif ?>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="form-input container" id="signup-password">
          <p>Palavra-passe</p>
          <input type="password" name="password" placeholder="No mínimo 8 caracteres" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['password'] ?? ''); ?>">

          <!-- PASSWORD REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input'])): ?>
              <p class="error-message"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
            <?php if (isset($signupErrors['weak_password'])): ?>
              <p class="error-message"><?php echo $signupErrors['weak_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- REPEAT PASSWORD -->
        <div class="form-input container" id="signup-re-passord">
          <input type="password" name="repeat_password" placeholder="Confirme a palavra-passe"
            class="form-textbox-input">

          <!-- PASSWORD CONFIRMATION REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input'])): ?>
              <p class="error-message"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
            <?php if (isset($signupErrors['unmatching_password'])): ?>
              <p class="error-message"><?php echo $signupErrors['unmatching_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <button type="submit" class="signup btn">Continuar</button>
      </div>
    </form>
  </div>
</body>

</html>