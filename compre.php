<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/artwork_model.inc.php';

$artworkModel = new ArtworkModel($pdo);
$artworks = $artworkModel->getAllArtworks();

include 'includes/compre/shop_view.inc.php';
