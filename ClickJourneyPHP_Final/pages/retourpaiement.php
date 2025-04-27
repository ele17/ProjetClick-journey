<?php
session_start();
require_once("../includes/getapikey.php");

if (!isset($_POST["transaction"], $_POST["montant"], $_POST["vendeur"], $_POST["status"], $_POST["control"])) {
    echo "Erreur de retour de paiement.";
    exit;
}

$transaction = $_POST["transaction"];
$montant = $_POST["montant"];
$vendeur = $_POST["vendeur"];
$status = $_POST["status"];
$control_recu = $_POST["control"];
$api_key = getAPIKey($vendeur);

// Recalcul du control pour vérification
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

if ($control_calcule !== $control_recu) {
    echo "Erreur : contrôle de sécurité échoué.";
    exit;
}

if ($status === "accepted") {
    echo "<h2>Paiement accepté ! Merci pour votre confiance 🍻</h2>";

    // Enregistrement de la transaction
    $payments = file_exists("../data/payments.json") ? json_decode(file_get_contents("../data/payments.json"), true) : [];

    $payments[] = [
        "user" => $_SESSION["login"],
        "trip_id" => $_POST["trip_id"] ?? "inconnu",
        "transaction_id" => $transaction,
        "amount" => $montant,
        "payment_date" => date("Y-m-d H:i:s")
    ];

    file_put_contents("../data/payments.json", json_encode($payments, JSON_PRETTY_PRINT));

    echo "<a href='profil.php'>Voir mes barathons achetés</a>";

} else {
    echo "<h2>❌ Paiement refusé.</h2>";
    echo "<a href='accueil.php'>Retourner à l'accueil</a>";
}
