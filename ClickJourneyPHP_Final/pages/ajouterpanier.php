<?php
session_start();
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: circuits.php');
    exit;
}

$id = $_GET['id'];

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter ou incrémenter la quantité
if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]++; // Incrémente si déjà présent
} else {
    $_SESSION['panier'][$id] = 1; // Sinon, quantité 1
}

header('Location: panier.php');
exit;
?>
