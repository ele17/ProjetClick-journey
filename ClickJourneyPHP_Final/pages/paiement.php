<?php
session_start();
require_once("../includes/getapikey.php");

if (!isset($_POST["trip_id"]) || !isset($_POST["total_price"])) {
    echo "Erreur : données manquantes.";
    exit;
}

$tripId = intval($_POST["trip_id"]);
$totalPrice = floatval($_POST["total_price"]);
$vendeur = "MI-2_A";
$transaction = uniqid(); // Génère un ID unique
$retour_url = "http://localhost/retour_paiement.php"; // URL où l'utilisateur reviendra
$api_key = getAPIKey($vendeur);

// Construction de la valeur de contrôle
$control = md5($api_key . "#" . $transaction . "#" . $totalPrice . "#" . $vendeur . "#" . $retour_url . "#");
?>

<h2> Paiement de votre barathon</h2>
<p>Montant à payer : <?= number_format($totalPrice, 2, '.', '') ?> €</p>

<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
    <input type="hidden" name="transaction" value="<?= $transaction ?>">
    <input type="hidden" name="montant" value="<?= number_format($totalPrice, 2, '.', '') ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <input type="hidden" name="retour" value="<?= $retour_url ?>">
    <input type="hidden" name="control" value="<?= $control ?>">
    <input type="submit" value="Payer maintenant">
</form>
