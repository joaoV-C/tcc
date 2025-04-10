<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeria</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>
<style>
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
    padding: 2rem;
  }

  .artwork-card {
    border: 1px solid #ddd;
    padding: 1rem;
    text-align: center;
  }

  .artwork-image {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
  }
</style>

<body>
  <?php include 'includes/header.inc.php' ?>

  <h1>Galeria de Trabalhos</h1>
  <div class="gallery-grid">
    <?php foreach ($artworks as $artwork): ?>
      <a href="produto.php?id=<?= htmlspecialchars($artwork['id']) ?>">
        <div class="artwork-card">
          <img src="public/assets/images/<?= htmlspecialchars($artwork['image']) ?>"
            alt="<?= htmlspecialchars($artwork['name']) ?>"
            class="artwork-image">
          <h3><?= htmlspecialchars($artwork['name']) ?></h3>
          <p><?= htmlspecialchars($artwork['artist']) ?></p>
          <p>€<?= number_format($artwork['price'], 2) ?></p>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</body>

</html>