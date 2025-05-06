<?php
session_start();
require ('getapikey.php');
include 'header.php';

// Récupération des données depuis l’URL (en GET)
$transaction = $_GET['transaction'] ?? '';
$montant     = $_GET['montant'] ?? '';
$vendeur     = $_GET['vendeur'] ?? '';
$statut      = $_GET['status'] ?? '';  // 'accepted' ou autre
$control_recu = $_GET['control'] ?? '';

// Vérifie que toutes les données sont présentes
if (!$transaction || !$montant || !$vendeur || !$statut || !$control_recu) {
    echo "❌ Erreur : données manquantes dans l’URL de retour.";
    exit;
}

// Récupération de la clé API du vendeur
$api_key = getAPIKey($vendeur);

// Recalcule du hash attendu
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

// Comparaison du hash
if ($control_attendu !== $control_recu) {
    echo "<h2>❌ Erreur de sécurité : vérification du paiement échouée.</h2>";
    exit;
}

// Affichage du résultat selon le statut
if ($statut === 'accepted') {
    unset($_SESSION['panier']); // Vider le panier après paiement réussi
    echo "<h2>✅ Paiement accepté ! Merci pour votre commande.</h2>";
    echo "<p>Vous allez être redirigé vers l'accueil dans quelques secondes...</p>";
    header("refresh:5;url=accueil.php"); // Redirige après 5 secondes
} else {
    echo "<h2>❌ Paiement refusé. Veuillez réessayer.</h2>";
    echo "<p>Retour au panier dans quelques secondes...</p>";
    header("refresh:5;url=panier.php");
}
