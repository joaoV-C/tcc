<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página da administração</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <script src="/tcc/js/index.js"></script>
</head>

<body>
  <?php include __DIR__ . '/includes/header.inc.php' ?>

  <div class="admin container">
    <div class="admin-links">
      <ul>
        <li>
          <form action="/tcc/admin?page=users" method="post" class="admin page form">
            <input type="hidden" name="page" value="users">
            <button type="submit" class="btn admin-btn">Usuários</button>
          </form>
        </li>
        <li>
          <form action="/tcc/admin?page=all_orders" method="post" class="admin page form">
            <input type="hidden" name="page" value="all_orders">
            <button type="submit" class="btn admin-btn">Pedidos</button>
          </form>
        </li>
        <li>
          <form action="/tcc/admin?page=all_products" method="post" class="admin page form">
            <input type="hidden" name="page" value="all_products">
            <button type="submit" class="btn admin-btn">Produtos</button>
          </form>
        </li>
      </ul>
    </div>
    <!-- ALL USERS -->
    <?php if (isset($_GET['page']) && $_GET['page'] === 'users'): ?>
      <?php if (empty($allUsers)): ?>
        <p>Não há nenhum usuário cadastrado.</p>
      <?php else: ?>
        <div class="user container">
          <table class="user table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($allUsers as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id']) ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td>
                    <form action="" method="post" class="cancel form">
                      <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                      <button type="submit" name="erase_user"
                        class="btn btn-danger delete-user-btn"
                        onclick="return confirm('Apagar usuário? Esta ação não pode ser desfeita')">
                        Apagar usuário
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      <!-- ALL ORDERS -->
    <?php elseif (isset($_GET['page']) && $_GET['page'] === 'all_orders'): ?>
      <table class="table admin-order-table">
        <thead>
          <tr>
            <th>N pedido</th>
            <th>Email</th>
            <th>Nome</th>
            <th>Tel.</th>
            <th>País</th>
            <th>End.</th>
            <th>Complemento</th>
            <th>Cidade</th>
            <th>Distrito</th>
            <th>Cód. Postal</th>
            <th>Total</th>
            <th>Produto</th>
            <th>Quant.</th>
            <th>Preço Unitário</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($groupedOrders as $orderId => $orderInfo): ?>
            <tr>
              <td><?= htmlspecialchars($orderId) ?></td>
              <td><?= htmlspecialchars($orderInfo['email']) ?></td>
              <td><?= htmlspecialchars($orderInfo['full_name']) ?></td>
              <td><?= htmlspecialchars($orderInfo['phone_number']) ?></td>
              <td><?= htmlspecialchars($orderInfo['country']) ?></td>
              <td><?= htmlspecialchars($orderInfo['street_addr']) ?></td>
              <td><?= htmlspecialchars($orderInfo['complement']) ?></td>
              <td><?= htmlspecialchars($orderInfo['city']) ?></td>
              <td><?= htmlspecialchars($orderInfo['district']) ?></td>
              <td><?= htmlspecialchars($orderInfo['postal_code']) ?></td>
              <td><?= htmlspecialchars($orderInfo['total']) ?></td>
              <?php foreach ($orderInfo['items'] as $item): ?>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
                <td><?= htmlspecialchars($item['order_date']) ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
      <!-- PRODUCTS GRID -->
    <?php elseif (isset($_GET['page']) && $_GET['page'] === 'all_products'): ?>
      <div class="grid gallery-grid">

        <form action="/tcc/admin?page=add_new_artwork" method="post" class="form add-artwork-form">
          <input type="hidden" name="page" value="add_new_artwork">
          <button type="submit" class="btn add-artwork-btn">
            <i class="fa-solid fa-plus"></i>
          </button>
        </form>

        <?php foreach ($artworks as $artwork): ?>
          <div>
            <a title="Ver na loja" href="/tcc/shop#<?= htmlspecialchars($artwork['id']) ?>">
              <div class="artwork-card">
                <img src="public/assets/images/<?= htmlspecialchars($artwork['image']) ?>"
                  alt="<?= htmlspecialchars($artwork['name']) ?>"
                  class="artwork-image">
                <h3><?= htmlspecialchars($artwork['name']) ?></h3>
                <p><?= htmlspecialchars($artwork['artist']) ?></p>
                <p>€<?= number_format($artwork['price'], 2) ?></p>
              </div>
            </a>
            <form action="/tcc/admin?page=edit_product&id=<?= htmlspecialchars($artwork['id']) ?>" method="post">
              <input type="hidden" name="page" value="edit_product">
              <input type="hidden" name="id" value="<?= htmlspecialchars($artwork['id']) ?>">
              <button type="submit" class="btn edit-product-btn">Editar</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- PRODUCT EDITING PAGE -->
    <?php elseif (isset($_GET['page'], $_GET['id']) && $_GET['page'] === 'edit_product'): ?>
      <div class="product-container"> <!-- container product-edit-container -->

        <img src="public/assets/images/<?= htmlspecialchars($artworkById['image'] ?? $_SESSION['artwork_edit_data']['image_file']) ?>"
          alt="<?= htmlspecialchars($artworkById['name'] ?? $_SESSION['artwork_edit_data']['product_name']) ?>"
          class="product-image">

        <form action="/tcc/admin?page=save_artwork_changes" method="post" enctype="multipart/form-data">
          <h2>
            Imagem:
            <input type="file" name="new_image" class="input image-upload-input">
          </h2>
          <h2>
            Título:
            <input type="text" name="product_name" class="input-error" value="<?= htmlspecialchars($artworkById['name'] ?? $_SESSION['artwork_edit_data']['product_name']) ?>">
          </h2>
          <h2>
            Ano:
            <input type="text" name="product_date" value="<?= htmlspecialchars($artworkById['date'] ?? $_SESSION['artwork_edit_data']['product_date']) ?>">
          </h2>
          <h2>
            Artista:
            <input type="text" name="artist_name" class="input-error" value="<?= htmlspecialchars($artworkById['artist'] ?? $_SESSION['artwork_edit_data']['artist_name']) ?>">
          </h2>
          <h2>
            Preço: €
            <?php if (!isset($_SESSION['artwork_edit_data']['product_price'])): ?>
              <input type="text" name="product_price" class="input-error" value="<?= number_format($artworkById['price'], 2) ?>">
            <?php else: ?>
              <input type="text" name="product_price" class="input-error" value="<?= number_format($_SESSION['artwork_edit_data']['product_price'], 2) ?>">
            <?php endif; ?>
          </h2>

          <input type="hidden" name="page" value="save_artwork_changes">
          <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($artworkById['id']) ?>">
          <button type="submit" class="btn artwork-btn save-changes"
            onclick="return confirm('Salvar mudanças? Esta ação não pode ser desfeita')">
            Salvar
          </button>
        </form>


        <form action="/tcc/admin" method="post">
          <input type="hidden" name="page" value="delete_artwork">
          <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($artworkById['id']) ?>">
          <button type="submit" class="btn artwork-btn delete"
            onclick="return confirm('Apagar usuário? Esta ação não pode ser desfeita')">
            Deletar produto
          </button>
        </form>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['page']) && $_GET['page'] === 'add_new_artwork'): ?>
      <div class="product-container"> <!-- container product-edit-container -->

        <form action="/tcc/admin?page=save_new_artwork" method="post" enctype="multipart/form-data">
          <h2>
            Imagem:
            <input type="file" name="new_image" class="input image-upload-input input-error">
          </h2>
          <h2>
            Título:
            <input type="text" name="product_name" class="input-error">
          </h2>
          <h2>
            Ano:
            <input type="text" name="product_date">
          </h2>
          <h2>
            Artista:
            <input type="text" name="artist_name" class="input-error">
          </h2>
          <h2>
            Preço: €
            <input type="text" name="product_price" class="input-error">
          </h2>

          <input type="hidden" name="page" value="save_new_artwork">
          <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($artworkById['id']) ?>">
          <button type="submit" class="btn artwork-btn save-changes"
            onclick="return confirm('Salvar mudanças? Esta ação não pode ser desfeita')">
            Salvar
          </button>
        </form>

      </div>
    <?php endif; ?>

  </div>

  <?php if (!empty($adminErrors['empty_input'])): ?>
    <script type="text/javascript" async>
      const errorMessage = <?php echo json_encode($adminErrors['empty_input']); ?>;
      console.log(errorMessage);
      errorBorderCreator(errorMessage);
    </script>
  <?php endif; ?>
</body>

</html>