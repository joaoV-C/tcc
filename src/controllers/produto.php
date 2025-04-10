<?php
require_once 'src/config/config_session.php';
require_once 'includes/dbh.inc.php';
require_once '/src/models/artwork_model.php';

if (!isset($_GET['id'])) {
  header("Location: compre.php");
  exit();
}

$artworkModel = new ArtworkModel($pdo);
$artwork = $artworkModel->getArtworkById($_GET['id']);

if (!$artwork) {
  header("Location: compre.php");
  exit();
}

include 'includes/produto/product_view.inc.php';
