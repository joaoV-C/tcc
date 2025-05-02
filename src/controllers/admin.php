<?php
function handleAdminRequest(): void {

  try {
    if (!isset($_SESSION['user_id'])) {
      header('Location: /tcc/signin');
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['page'])) {
      $userModel = new UserModel($GLOBALS['pdo']);
      $artworkModel = new ArtworkModel($GLOBALS['pdo']);

      function refreshUsersSessionData($userModel): void {
        $allUsers = $userModel->getAllUsers();
        $_SESSION['all_users'] = $allUsers;
      }

      function refreshArtworksSessionData($artworkModel): void {
        $artworks = $artworkModel->getAllArtworks();
        $_SESSION['artworks'] = $artworks;
      }

      function refreshArtworkByIdSessionData($artworkModel, $artworkId): mixed {
        $artworkById = $artworkModel->getArtworkById($artworkId);
        $_SESSION['artwork_by_id'] = $artworkById;
        return $artworkById;
      }

      $errors = [];

      if (isset($_POST['page']) && $_POST['page'] === 'users') {
        $userEmail = strtolower($_SESSION['user_email']);
        $adminEmails = [
          'admin@email.com'
        ];
        $isAdmin = in_array($userEmail, $adminEmails);

        if (!$isAdmin) {
          $errors['is_not_admin'] = 'Área restrita a administradores';
        }

        if (!empty($errors)) {
          header('Location: /tcc/account?action=redirection');
          exit();
        } elseif (isset($_POST['user_id'], $_POST['delete_user'])) {
          $userId = $_POST['user_id'];
          $userEmail = $_POST['user_email'];
          $deleteUser = $userModel->deleteUser($userId);

          $_SESSION['admin_success']['user_delete_success'] = 'Usuário de id #' . $userId . ' e email ' . $userEmail . ' deletado com sucesso.';

          refreshUsersSessionData($userModel);
          header('Location: /tcc/admin?page=users&action=delete_user_success');
          exit();
        } else {
          refreshUsersSessionData($userModel);
          header('Location: /tcc/admin?page=users');
          exit();
        }
      } elseif (isset($_POST['page']) && $_POST['page'] === 'all_orders') {
        $allOrders = $userModel->getAllOrders();
        $groupedOrders = [];

        foreach ($allOrders as $item) {
          $orderId = $item['order_id'];

          if (!isset($groupedOrders[$orderId])) {
            $groupedOrders[$orderId] = [
              'email' => $item['email'],
              'full_name' => $item['full_name'],
              'phone_number' => $item['phone_number'],
              'country' => $item['country'],
              'street_addr' => $item['street_addr'],
              'complement' => $item['complement'],
              'city' => $item['city'],
              'district' => $item['district'],
              'postal_code' => $item['postal_code'],
              'total' => $item['total'],
              'order_date' => $item['order_date'],
              'items' => []
            ];
          }

          $groupedOrders[$orderId]['items'][] = $item;
        }
      } elseif (isset($_POST['page']) && $_POST['page'] === 'all_products') {

        refreshArtworksSessionData($artworkModel);

        header('Location: /tcc/admin?page=all_products');
        exit();
      } elseif (isset($_POST['page'], $_POST['id']) && $_POST['page'] === 'edit_product') {
        $artworkId = $_POST['id'];
        $artworkById = refreshArtworkByIdSessionData($artworkModel, $artworkId);

        header('Location: /tcc/admin?page=edit_product&id=' . $artworkById['id']);
        exit();
      } elseif (isset($_POST['page'], $_POST['artwork_id']) && $_POST['action'] === 'save_artwork_changes') {
        $artworkId = $_POST['artwork_id'];
        $artworkById = refreshArtworkByIdSessionData($artworkModel, $artworkId);

        //$currentImage = $artworkById['image'];
        //$imageFile = $_FILES['new_image']['tpm_name'];
        $productName = $_POST['product_name'];
        $productDate = $_POST['product_date'];
        $artistName = $_POST['artist_name'];
        $productPrice = $_POST['product_price'];
        $productId = $_POST['artwork_id'];

        if (!empty($_FILES['new_image']['tmp_name'])) {
          $uploadDir = 'public/assets/images/';
          $imageFile = basename($_FILES['new_image']['name']);
          $uploadFile = $uploadDir . $imageFile;

          if (move_uploaded_file($_FILES['new_image']['tmp_name'], $uploadFile)) {
            $success['upload_success'] = 'Upload realizado com sucesso';
          } else {
            $errors['upload_fail'] = 'Falha no upload do arquivo';
            //die('Falha no upload do arquivo');
          }
        } else {
          // Keep the existing filename
          $imageFile = $artworkById['image'];
        }

        if (empty($productName) || empty($artistName) || empty($productPrice)) {
          $errors['empty_input'] = '*Campo de preenchimento obrigatório';
        }
        if (!is_numeric($productPrice)) {
          $errors['invalid_data_type'] = 'O campo do Preço dever ser preenchido por um valor numérico';
        }

        $artworkEditData = [
          'image_file' => $imageFile,
          'product_name' => $productName,
          'product_date' => $productDate,
          'artist_name' => $artistName,
          'product_price' => $productPrice,
          'product_id' => $productId
        ];

        if (!empty($errors)) {
          $_SESSION['admin_errors'] = $errors;
          $_SESSION['artwork_edit_data'] = $artworkEditData;

          header('Location: /tcc/admin?page=edit_product&action=fail_to_edit&id=' . $productId);
          exit();
        } else {
          $success['save_edit_success'] = 'Edições salvas com sucesso';
          $_SESSION['artwork_edit_data'] = $artworkEditData;
          $_SESSION['admin_success'] = $success;

          $updateArtworkData = $artworkModel->updateArtworks($artworkEditData);

          refreshArtworkByIdSessionData($artworkModel, $artworkId);

          //header('Location: /tcc/admin?page=all_products&action=edit_product_success&productId=' . $productId);
          header('Location: /tcc/admin?page=edit_product&action=edit_product_success&id=' . $productId);
          exit();
        }
      } elseif (isset($_POST['page'], $_POST['artwork_id']) && $_POST['page'] === 'delete_artwork') {
        $artworkId = $_POST['artwork_id'];
        $deleteArtwork = $artworkModel->deleteArtwork($artworkId);

        $_SESSION['admin_success']['delete_product'] = 'O produto de id #' . $artworkId . ' foi excluído com sucesso';

        refreshArtworksSessionData($artworkModel);

        header('Location: /tcc/admin?page=all_products&action=product_deleted');
        exit();
      } elseif (isset($_POST['page']) && $_POST['page'] === 'add_new_artwork') {
        unset($_SESSION['new_artwork_data']);

        header('Location: /tcc/admin?page=add_new_artwork');
        exit();
      } elseif (isset($_POST['page']) && $_POST['page'] === 'save_new_artwork') {
        $imageFile = $_FILES['new_image']['name'];
        $productName = $_POST['product_name'];
        $productDate = $_POST['product_date'];
        $artistName = $_POST['artist_name'];
        $productPrice = $_POST['product_price'];
        $newArtworkData = [];

        if (empty($imageFile) || empty($productName) || empty($artistName) || empty($productPrice)) {
          $errors['empty_input'] = '*Campo de preenchimento obrigatório';
        }
        if (!is_numeric($productPrice)) {
          $errors['invalid_data_type'] = 'O campo do Preço dever ser preenchido por um valor numérico';
        }

        $newArtworkData = [
          'image_file' => $imageFile,
          'product_name' => $productName,
          'product_date' => $productDate,
          'artist_name' => $artistName,
          'product_price' => $productPrice
        ];

        if (!empty($errors)) {
          $_SESSION['admin_errors'] = $errors;
          $_SESSION['new_artwork_data'] = $newArtworkData;

          header('Location: /tcc/admin?page=add_new_artwork&action=fail_to_add_product');
          exit('Erro ao gravar novo produto');
        } else {
          //$_SESSION['artwork_edit_data'] = $newArtworkData;
          $_SESSION['admin_success']['add_new_product_success'] = 'Produto criado com sucesso.';

          $getArtworkByName = $artworkModel->getArtworkByName($newArtworkData['product_name']);
          $addNewArtwork = $artworkModel->addNewArtwork($newArtworkData);

          unset($_SESSION['new_artwork_data']);
          header('Location: /tcc/admin?page=add_new_artwork&action=new_product_success');
          exit();
        }
      }
    }
  } catch (PDOException $e) {
    $error = 'Erro na base de dados: ' . $e->getMessage();
    $_SESSION['admin_errors'] = $error;
  }

  $adminErrors = $_SESSION['admin_errors'] ?? '';
  $adminSuccess = $_SESSION['admin_success'] ?? '';
  unset($_SESSION['admin_errors'], $_SESSION['admin_success']);

  include __DIR__ . '/../views/admin_view.php';
}
