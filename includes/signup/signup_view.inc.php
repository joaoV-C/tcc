<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .signup-container {
      display: flex;
      flex-direction: column;
      padding-top: 80px;
    }

    form .signup-content {
      margin: 30px auto;
      max-width: 460px;
      width: 40%;
    }

    .signup-content h2 {
      padding-bottom: 15px;
      text-align: center;
    }

    .signup-input {
      padding-top: 15px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .signup-input .form-textbox-input {
      border: 1px solid;
      border-radius: 5px;
      border-color: #333;
      /* #86868b */
      margin-bottom: 13.2px;
      padding: 10px 12px;
      box-sizing: border-box;
      font-family: "Sarabun", serif;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.6rem;
      width: 100%;
    }

    .signup-input .form-textbox-input input {
      color: #1d1d1f;
      text-overflow: ellipsis;
    }
  </style>
</head>

<body>
  <?php include('includes/header.inc.php'); ?>

  <div class="signup-container">

    <form method="POST">

      <div class="signup-content">
        <h2>Criar Conta</h2>

        <?php if (!empty($signupSuccess)): ?>
          <div class="success_message">
            <!-- REGISTRATION SUCCESS MESSAGE -->
            <h3><?php echo $signupSuccess; ?></h3>
          </div>
        <?php endif; ?>

        <!-- USERNAME -->
        <div class="signup-input username">
          <p>Digite o seu nome</p>
          <input type="text" name="username" placeholder="Nome" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['username'] ?? ''); ?>">

          <!-- USERNAME REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (!empty($signupErrors['empty_input']) && empty($signupData['username'])): ?>
              <p class="error"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- EMAIL -->
        <div class="signup-input email">
          <p>Email</p>
          <input type="email" name="email" placeholder="nome@example.com" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['email'] ?? ''); ?>">

          <!-- EMAIL REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input']) && empty($signupData['email'])): ?>
              <p class="error"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif ?>
            <?php if (isset($signupErrors['invalid_email'])): ?>
              <p class="error"><?php echo $signupErrors['invalid_email']; ?></p>
            <?php endif ?>
            <?php if (isset($signupErrors['registered_email'])): ?>
              <p class="error"><?php echo $signupErrors['registered_email']; ?></p>
            <?php endif ?>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="signup-input password">
          <p>Palavra-passe</p>
          <input type="password" name="password" placeholder="No mínimo 8 caracteres" class="form-textbox-input"
            value="<?php echo htmlspecialchars($signupData['password'] ?? ''); ?>">

          <!-- PASSWORD REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input'])): ?>
              <p class="error"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
            <?php if (isset($signupErrors['weak_password'])): ?>
              <p class="error"><?php echo $signupErrors['weak_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- REPEAT PASSWORD -->
        <div class="signup-input re-password">
          <input type="password" name="repeat_password" placeholder="Confirme a palavra-passe"
            class="form-textbox-input">

          <!-- PASSWORD CONFIRMATION REGISTRATION ERROR MESSAGES -->
          <div class="form-message-wrapper">
            <?php if (isset($signupErrors['empty_input'])): ?>
              <p class="error"><?php echo $signupErrors['empty_input']; ?></p>
            <?php endif; ?>
            <?php if (isset($signupErrors['unmatching_password'])): ?>
              <p class="error"><?php echo $signupErrors['unmatching_password']; ?></p>
            <?php endif; ?>
          </div>
        </div>

        <button type="submit">Continuar</button>
      </div>
    </form>
  </div>
</body>

</html>