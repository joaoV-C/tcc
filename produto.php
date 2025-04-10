<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/artwork_model.inc.php';

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
