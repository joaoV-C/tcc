<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($artwork['name']) ?></title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>
<style>
  .product-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
  }

  .product-image {
    max-width: 100%;
    height: 400px;
    object-fit: cover;
  }
</style>

<body>
  <?php include 'includes/header.inc.php' ?>

  <div class="product-container">
    <img src="public/assets/images/<?= htmlspecialchars($artwork['image']) ?>"
      alt="<?= htmlspecialchars($artwork['name']) ?>"
      class="product-image">
    <h1>
      <?= htmlspecialchars($artwork['name']) ?>
      (<?= htmlspecialchars($artwork['date']) ?>)
    </h1>
    <h2><?= htmlspecialchars($artwork['artist']) ?></h2>
    <p>Preço: €<?= number_format($artwork['price'], 2) ?></p>

    <form action="/tcc/basket.php" method="post">
      <div class="basket-form-content">
        <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($artwork['id']) ?>">
        <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
        <button type="submit">Adicinar à Cesta</button>
      </div>
    </form>
  </div>
</body>

</html>