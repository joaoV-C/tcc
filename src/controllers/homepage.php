<?php
function handleHomepageRequest(): void {
  $artworkModel = new ArtworkModel($GLOBALS['pdo']);
  $artworks = $artworkModel->getAllArtworks();

  include __DIR__ . '/../views/homepage_view.php';
}
