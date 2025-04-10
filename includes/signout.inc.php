<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // 405 = Method Not Allowed
  exit('Deslogar necessita uma solicitação do tipo POST');
} else {

  session_start();

  if (!isset($_POST['action_token']) || $_POST['action_token'] !== '123') {
    http_response_code(403); // 403 = Forbidden
    exit('Token de ação inválido');
  } else {

    session_unset();
    session_destroy();


    header("Location: ../signin.php?action=logout&status=sucesso");
    exit;
  }
}
