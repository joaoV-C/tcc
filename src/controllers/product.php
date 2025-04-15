<?php
function handleProductRequest(): void {

  if (!isset($_GET['id'])) {
    header("Location: /tcc/shop");
    exit();
  }

  $artworkModel = new ArtworkModel($GLOBALS['pdo']);
  $artwork = $artworkModel->getArtworkById($_GET['id']);

  if (!$artwork) {
    header("Location: /tcc/shop");
    exit();
  }

  include __DIR__ . '/../views/product_view.inc.php';
}
