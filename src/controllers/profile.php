<?php require_once 'src/config/config_session.php';

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
    }
  }
} catch (\Throwable $th) {
  //throw $th;
}


include 'src/views/profile_view.php';
