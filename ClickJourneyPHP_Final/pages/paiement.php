<?php
session_start();
require('getapikey.php');
include 'header.php';

$montant_total=38.00;

// Préparation des données pour CYBank
$montant = number_format((float)$montant_total, 2, '.', '');
$transaction = uniqid();
$vendeur = 'MIM_F';
$retour = "http://localhost/PHPtest/ClickJourneyPHP/pages/retourpaiement.php?session=" . session_id();
$api_key = getAPIKey($vendeur);

// Calcul du hash de contrôle
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
</head>
<body>
    <h2>Récapitulatif du paiement</h2>
    <p>Montant total à payer : <strong><?= htmlspecialchars($montant) ?> €</strong></p>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction) ?>">
        <input type="hidden" name="montant" value="<?= htmlspecialchars($montant) ?>">
        <input type="hidden" name="vendeur" value="<?= htmlspecialchars($vendeur) ?>">
        <input type="hidden" name="retour" value="<?= htmlspecialchars($retour) ?>">
        <input type="hidden" name="control" value="<?= htmlspecialchars($control) ?>">
        <input type="submit" value="Payer maintenant">
    </form>
</body>
</html>
