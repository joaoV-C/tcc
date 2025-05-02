<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página da administração</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <?php include __DIR__ . '/includes/header.inc.php' ?>

  <div class="general-content-container admin-container">
    <ul class="admin-links">
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
    <!-- ALL USERS -->
    <?php if (isset($_GET['page']) && $_GET['page'] === 'users'): ?>
      <?php if (empty($_SESSION['all_users'])): ?>
        <p>Não há nenhum usuário cadastrado.</p>
      <?php else: ?>

        <?php if (isset($adminSuccess['user_delete_success'])): ?>
          <p class="alert alert-success">
            <?= htmlspecialchars($adminSuccess['user_delete_success']) ?>
          </p>
        <?php endif; ?>

        <div class="table-container users-table-container">
          <table class="table all-users-table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['all_users'] as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id']) ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td>
                    <form action="/tcc/admin" method="post" class="form delete-user-form">
                      <input type="hidden" name="page" value="users">
                      <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                      <input type="hidden" name="user_email" value="<?= htmlspecialchars($user['email']) ?>">
                      <button type="submit" name="delete_user"
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
      <div class="table-container orders-table-container">
        <table class="table all-orders-table">
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
              <?php $numItems = count($orderInfo['items']); ?>
              <?php $i = 0; ?>
              <?php foreach ($orderInfo['items'] as $item): ?>
                <tr>
                  <?php if ($i === 0): ?>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderId) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['email']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['full_name']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['phone_number']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['country']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['street_addr']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['complement']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['city']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['district']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['postal_code']) ?></td>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($orderInfo['total']) ?></td>
                  <?php endif; ?>

                  <td><?= htmlspecialchars($item['product_name']) ?></td>
                  <td><?= htmlspecialchars($item['quantity']) ?></td>
                  <td><?= htmlspecialchars($item['price']) ?></td>

                  <?php if ($i === 0): ?>
                    <td rowspan="<?= $numItems ?>"><?= htmlspecialchars($item['order_date']) ?></td>
                  <?php endif; ?>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- PRODUCTS GRID -->
    <?php elseif (isset($_GET['page']) && $_GET['page'] === 'all_products'): ?>

      <?php if (isset($adminSuccess['delete_product'])): ?>
        <p class="alert alert-success">
          <?= htmlspecialchars($adminSuccess['delete_product']) ?>
        </p>
      <?php endif; ?>

      <div class="grid gallery-grid">

        <form action="/tcc/admin?page=add_new_artwork" method="post" class="form add-artwork-form">
          <input type="hidden" name="page" value="add_new_artwork">
          <button type="submit" class="btn add-artwork-btn">
            <i class="fa-solid fa-plus"></i>
          </button>
        </form>

        <?php foreach ($_SESSION['artworks'] as $artwork): ?>

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

      <?php if (isset($adminErrors['upload_fail'])): ?>
        <p class="alert alert-error">
          <?= htmlspecialchars($adminErrors['upload_fail']) ?>
        </p>
      <?php elseif (isset($adminSuccess['save_edit_success'])): ?>
        <p class="alert alert-success">
          <?= htmlspecialchars($adminSuccess['save_edit_success']) ?>
        </p>
      <?php endif; ?>

      <div class="product-container edit-product-container">

        <div class="image-container">
          <img src="public/assets/images/<?= htmlspecialchars($_SESSION['artwork_by_id']['image']) ?>"
            alt="<?= htmlspecialchars($_SESSION['artwork_by_id']['name']) ?>"
            class="product-image edit-product-image">
        </div>
        <div class="products-edit-forms">
          <form action="/tcc/admin" method="post" enctype="multipart/form-data" class="edit-product-form">
            <h2>
              Imagem:
              <input type="file" name="new_image" class="input image-upload-input">
            </h2>
            <h2>
              Título:
              <input type="text" name="product_name" class="input-error" value="<?= htmlspecialchars($_SESSION['artwork_by_id']['name']) ?>">
            </h2>
            <h2>
              Ano:
              <input type="text" name="product_date" value="<?= htmlspecialchars($_SESSION['artwork_by_id']['date']) ?>">
            </h2>
            <h2>
              Artista:
              <input type="text" name="artist_name" class="input-error" value="<?= htmlspecialchars($_SESSION['artwork_by_id']['artist']) ?>">
            </h2>
            <h2>
              Preço: €
              <input type="text" name="product_price" class="input-error price-input" value="<?= number_format($_SESSION['artwork_by_id']['price'], 2) ?>">
            </h2>

            <input type="hidden" name="action" value="save_artwork_changes">
            <input type="hidden" name="page" value="save_artwork_changes">
            <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($_SESSION['artwork_by_id']['id']) ?>">
            <button type="submit" class="btn artwork-btn save-changes"
              onclick="return confirm('Salvar mudanças? Esta ação não pode ser desfeita')">
              Salvar
            </button>
          </form>

          <form action="/tcc/admin" method="post">
            <input type="hidden" name="action" value="delete_artwork">
            <input type="hidden" name="page" value="delete_artwork">
            <input type="hidden" name="artwork_id" value="<?= htmlspecialchars($_SESSION['artwork_by_id']['id']) ?>">
            <button type="submit" class="btn artwork-btn delete"
              onclick="return confirm('Apagar usuário? Esta ação não pode ser desfeita')">
              Deletar produto
            </button>
          </form>

        </div>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['page']) && $_GET['page'] === 'add_new_artwork'): ?>

      <?php if (isset($adminSuccess['add_new_product_success'])): ?>
        <p class="alert alert-success">
          <?= htmlspecialchars($adminSuccess['add_new_product_success']) ?>
          <a href="/tcc/shop#<?= htmlspecialchars($getArtworkByName['id']) ?>"> Ver na loja.</a>
        </p>
      <?php endif; ?>

      <div class="product-container products-edit-forms">

        <form action="/tcc/admin?page=save_new_artwork" method="post" enctype="multipart/form-data">
          <h2>
            Imagem:
            <input type="file" name="new_image" class="input image-upload-input input-error">
          </h2>
          <h2>
            Título:
            <input type="text" name="product_name" class="input-error" value="<?= htmlspecialchars($_SESSION['new_artwork_data']['product_name'] ?? '') ?>">
          </h2>
          <h2>
            Ano:
            <input type="text" name="product_date" value="<?= htmlspecialchars($_SESSION['new_artwork_data']['product_date'] ?? '') ?>">
          </h2>
          <h2>
            Artista:
            <input type="text" name="artist_name" class="input-error" value="<?= htmlspecialchars($_SESSION['new_artwork_data']['artist_name'] ?? '') ?>">
          </h2>
          <h2>
            Preço: €
            <input type="text" name="product_price" class="input-error price-input" value="<?= htmlspecialchars($_SESSION['new_artwork_data']['product_price'] ?? '') ?>">
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

  <script src="/tcc/js/index.js"></script>

  <?php if (!empty($adminErrors['empty_input']) && !empty($adminErrors['invalid_data_type'])): ?>
    <script type="text/javascript">
      const errorMessage = <?php echo json_encode($adminErrors['empty_input']); ?>;
      const priceErrorMessage = <?php echo json_encode($adminErrors['invalid_data_type']); ?>;

      bothErrorsDisplay(errorMessage, priceErrorMessage);
    </script>
  <?php elseif (!empty($adminErrors['empty_input'])): ?>
    <script type="text/javascript">
      const errorMessage = <?php echo json_encode($adminErrors['empty_input']); ?>;
      console.log(errorMessage);
      emptyInputErrorDisplay(errorMessage);
    </script>
  <?php elseif (!empty($adminErrors['invalid_data_type'])): ?>
    <script type="text/javascript">
      const priceErrorMessage = <?php echo json_encode($adminErrors['invalid_data_type']); ?>;
      console.log(priceErrorMessage);
      priceInputErrorDisplay(priceErrorMessage);
    </script>
  <?php endif; ?>

</body>

</html>