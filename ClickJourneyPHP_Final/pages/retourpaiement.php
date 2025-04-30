<?php
require_once('getapikey.php');

$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$statut = $_GET['statut'] ?? '';
$control_recu = $_GET['control'] ?? '';

$api_key = getAPIKey($vendeur);
$control_attendu = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control_recu === $control_attendu) {
    if ($statut === 'accepted') {
        echo " Paiement accepté !";
    } else {
        echo " Paiement refusé.";
    }
} else {
    echo " Vérification échouée : contrôle invalide.";
}
?>
