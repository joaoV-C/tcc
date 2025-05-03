<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeria</title>
  <link rel="stylesheet" href="/tcc/css/styles.css">
</head>
<style>
  .artwork-image {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
  }
</style>

<body>
  <?php include 'includes/header.inc.php' ?>

  <div class="general-content-container">
    <h1 class="page-h1">Prints de arte</h1>

    <div class="gallery-grid">
      <?php foreach ($artworks as $artwork): ?>
        <a href="/tcc/product?id=<?= htmlspecialchars($artwork['id']) ?>" id="<?= htmlspecialchars($artwork['id']) ?>">
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
  </div>
</body>

</html>