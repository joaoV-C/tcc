<?php
function handleShopRequest(): void {
  $artworkModel = new ArtworkModel($GLOBALS['pdo']);
  $artworks = $artworkModel->getAllArtworks();

  include __DIR__ . '/../views/shop_view.inc.php';
}
