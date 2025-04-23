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

      $errors = [];

      if (isset($_POST['page']) && $_POST['page'] === 'users') {
        $allUsers = $userModel->getAllUsers();

        $userEmail = strtolower($_SESSION['user_email']);
        $adminEmails = [
          'admin@email.com'
        ];
        $isAdmin = in_array($userEmail, $adminEmails);

        if (!$isAdmin) {
          header('Location: /tcc/account?action=redirection');
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
        $artworks = $artworkModel->getAllArtworks();
      } elseif (isset($_POST['page'], $_POST['id']) && $_POST['page'] === 'edit_product') {
        $artworkById = $artworkModel->getArtworkById($_POST['id']);
      } elseif (isset($_POST['page'], $_POST['artwork_id']) && $_POST['page'] === 'save_artwork_changes') {
        $artworkById = $artworkModel->getArtworkById($_POST['artwork_id']);

        $currentImage = $artworkById['image'];
        //$imageFile = $_FILES['new_image']['tpm_name'];
        $productName = $_POST['product_name'];
        $productDate = $_POST['product_date'];
        $artistName = $_POST['artist_name'];
        $productPrice = $_POST['product_price'];
        $productId = $_POST['artwork_id'];

        if (!empty($_FILES['new_image']['tpm_name'])) {
          $uploadDir = 'public/assets/images/';
          $imageFile = basename($_FILES['new_image']['name']);
          $uploadFile = $uploadDir . $imageFile;

          if (move_uploaded_file($_FILES['new_image']['tpm_name'], $uploadFile)) {
            $success['upload_success'] = 'Upload do arquivo realizado com sucesso';
          } else {
            $errors['upload_fail'] = 'Falha no upload do arquivo';
            die('Falha no upload do arquivo');
          }
        } else {
          // Keep the existing filename
          $imageFile = $currentImage;
        }

        if (!isset($imageFile, $productName, $artistName, $productPrice)) {
          $errors['empty_input'] = '*Campo de preenchimento obrigatório';
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

          header('Location: /tcc/admin?page=edit_product&id=' . htmlspecialchars($productId) . '&action=fail_to_edit');
          exit('Erro ao gravar edição');
        } else {
          $_SESSION['artwork_edit_data'] = $artworkEditData;

          $updateArtworkData = $artworkModel->updateArtworks($artworkEditData);

          header('Location: /tcc/admin?page=edit_product&id=' . htmlspecialchars($productId) . '&action=edit_product');
          // header('Location: /tcc/product?id=' . htmlspecialchars($productId) . '&action=edit_product');
          exit();
        }
      } elseif (isset($_POST['page'], $_POST['artwork_id']) && $_POST['page'] === 'delete_artwork') {
        # code...
      } elseif (isset($_POST['page']) && $_POST['page'] === 'save_new_artwork') {
        $imageFile = $_FILES['new_image']['name'];
        $productName = $_POST['product_name'];
        $productDate = $_POST['product_date'];
        $artistName = $_POST['artist_name'];
        $productPrice = $_POST['product_price'];
        $newArtworkData = [];

        if (!isset($imageFile, $productName, $artistName, $productPrice)) {
          $errors['empty_input'] = '*Campo de preenchimento obrigatório';
        } else {
          $newArtworkData = [
            'image_file' => $imageFile,
            'product_name' => $productName,
            'product_date' => $productDate,
            'artist_name' => $artistName,
            'product_price' => $productPrice
          ];
        }

        if (!empty($errors)) {
          $_SESSION['admin_errors'] = $errors;
          $_SESSION['new_artwork_data'] = $newArtworkData;

          header('Location: /tcc/admin?page=add_new_artwork&action=fail_to_add_product');
          exit('Erro ao gravar novo produto');
        } else {
          $_SESSION['artwork_edit_data'] = $newArtworkData;

          $updateArtworkData = $artworkModel->updateArtworks($newArtworkData);

          header('Location: /tcc/admin?page=add_new_artwork&action=new_product_success');
          exit();
        }
      }
    }
  } catch (PDOException $e) {
    $error = 'Erro na base de dados: ' . $e->getMessage();
    $_SESSION['admin_errors'] = $error;
  }

  $adminErrors = $_SESSION['admin_errors'];
  $adminSuccess = $_SESSION['admin_success'];
  unset($_SESSION['admin_errors'], $_SESSION['admin_success']);

  include __DIR__ . '/../views/admin_view.php';
}
