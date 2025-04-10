<?php
class ArtworkModel {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function getAllArtworks() {
    $stmt = $this->pdo->query("SELECT * FROM artworks");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getArtworkById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM artworks WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
