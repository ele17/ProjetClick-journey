<?php
session_start();
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    unset($_SESSION['panier'][$id]);
}

header('Location: panier.php');
exit;
