<?php

session_start();
session_unset();
session_destroy();


if (isset($_POST['logout'])) {
  header("Location: ../index.php");
  exit;
}

header("Location: ../index.php");
die();
