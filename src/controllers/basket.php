<?php

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artwork_id'])) {

    $artworkModel = new ArtworkModel($GLOBALS['pdo']);
    $artwork = $artworkModel->getArtworkById($_POST['artwork_id']);

    if (isset($_POST['quantity'])) {

      if ($artwork) {

        $item = [
          'id' => $artwork['id'],
          'name' => $artwork['name'],
          'image' => $artwork['image'],
          'price' => $artwork['price'],
          'quantity' => $_POST['quantity']
        ];

        if (!isset($_SESSION['cart'])) {
          $_SESSION['cart'] = [];
        }

        $found = false; // Variable that serves to tell if there's a match between a new item 
        // and an existing one.

        foreach ($_SESSION['cart'] as &$cartItem) {

          // If the $item added is the same of an item that is already in the 
          // cart ($_SESSION['cart']['id'] === $item['id']), they both get summed.
          if ($cartItem['id'] === $item['id']) {
            $cartItem['quantity'] += $item['quantity'];
            $found = true;
            break;
          }
        }

        // If the variable $found is not true, initiate a new cart ($_SESSION['cart']) 
        // and store in to it the data that was stored in the $item variable,
        // provided by the form in "product_view.inc.php".
        if (!$found) {
          $_SESSION['cart'][] = $item;
        }
      }
    } elseif (isset($_POST['action'])) {

      $action = $_POST['action'];

      if (!isset($_SESSION['cart'])) {
        throw new Exception("Cesto está vazio");
      }

      foreach ($_SESSION['cart'] as &$item) {
        // Secures that the item being altered is really the one that has been selected by the user.
        if ($item['id'] === $artwork['id']) {

          switch ($action) { // If the value of $action is either 'subtract' or 'add', do...
            case 'subtract':
              if ($item['quantity'] > 1) {
                $item['quantity']--;
              } else {
                $index = array_search($item, $_SESSION['cart']);
                if ($index !== false) {
                  unset($_SESSION['cart'][$index]);
                }
              }
              break;

            case 'add':
              $item['quantity']++;
              break;
          }
          break;
        }
      }

      if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_values($_SESSION['cart']);
      }
    }
    // GET request redirection. It prevents the forms from being submitted again when the page reloads
    header("Location: /tcc/cart");
    exit();
  }
} catch (Exception $e) {
  $_SESSION['cart_errors'] = ("Falha na consulta: " . $e->getMessage());
  header("Location: /tcc/cart");
  exit();
}

$cartErrors = $_SESSION['cart_errors'] ?? '';
unset($_SESSION['cart_errors']);

include __DIR__ . '/../views/basket_view.inc.php';
