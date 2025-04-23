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

  public function addArtwork(): void {
  }

  public function updateArtworks(array $artworkEditData): void {
    $stmt = $this->pdo->prepare(
      "UPDATE artworks 
      SET image = :image,
          name = :name, 
          date = :date, 
          artist = :artist, 
          price = :price
      WHERE id = :artworkId"
    );

    $stmt->execute([
      'image' => $artworkEditData['image_file'],
      'name' => $artworkEditData['product_name'],
      'date' => $artworkEditData['product_date'],
      'artist' => $artworkEditData['artist_name'],
      'price' => $artworkEditData['product_price'],
      'artworkId' => $artworkEditData['product_id']
    ]);
  }
}
