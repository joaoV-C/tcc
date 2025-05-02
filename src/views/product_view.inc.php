<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($artwork['name']) ?></title>
  <link rel="stylesheet" href="/tcc/css/styles.css">
</head>
<style>
  .product-container {
    margin: 0 50px;
    padding-top: 100px;
    display: flex;
    gap: 30px;
    font-family: "Sarabun", sans-serif;
  }

  .product-image {
    max-width: 100%;
    height: 100%;
    min-width: 400px;
    /* object-fit: cover; */
  }
</style>

<body>
  <?php include 'includes/header.inc.php' ?>

  <div class="product-container">

    <div class="product-image-container">
      <img src="public/assets/images/<?= htmlspecialchars($artwork['image']) ?>"
        alt="<?= htmlspecialchars($artwork['name']) ?>"
        class="product-image">
    </div>

    <div class="product-info">
      <h1>
        <?= htmlspecialchars($artwork['name']) ?>
        (<?= htmlspecialchars($artwork['date']) ?>)
      </h1>
      <h2><?= htmlspecialchars($artwork['artist']) ?></h2>
      <p>Preço: €<?= number_format($artwork['price'], 2) ?></p>

      <form action="/tcc/cart" method="post">
        <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($artwork['id']) ?>">
        <span>
          <p>Quantidade </p>
          <input type="number" name="quantity" value="1" min="1" class="quantity-selector" style="width: 60px;" aria-label="Quantidade">
        </span>
        <button type="submit" class="btn add-to-cart-btn">Adicionar ao cesto</button>
      </form>
    </div>
  </div>
</body>

</html>