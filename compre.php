<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/artwork_model.inc.php';

$artworkModel = new ArtworkModel($pdo);
$artworks = $artworkModel->getAllArtworks();

include 'includes/compre/compre_view.inc.php';
