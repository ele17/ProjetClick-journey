<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantite'])) {
    $id = $_POST['id'];
    $quantite = (int)$_POST['quantite'];

    if ($quantite > 0) {
        $_SESSION['panier'][$id] = $quantite;
    } else {
        unset($_SESSION['panier'][$id]); // Supprime si quantité = 0
    }
}

header('Location: panier.php');
exit;
?>
