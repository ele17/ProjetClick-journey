<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: connexion.php");
    exit;
}

$login = $_SESSION["login"];
$users = json_decode(file_get_contents("../data/users.json"), true);
$trips = json_decode(file_get_contents("../data/trips.json"), true);
$payments = file_exists("../data/payments.json") ? json_decode(file_get_contents("../data/payments.json"), true) : [];

foreach ($users as $user) {
    if ($user["login"] === $login) {
        $user_trips = $user["purchased_trips"];
        break;
    }
}

echo "<h2>Bienvenue " . htmlspecialchars($login) . " 👋</h2>";

// Barathons achetés
echo "<h3>🧾 Vos barathons achetés :</h3>";
if (!empty($user_trips)) {
    echo "<ul>";
    foreach ($trips as $trip) {
        if (in_array($trip["id"], $user_trips)) {
            echo "<li><strong>{$trip["title"]}</strong> du {$trip["start_date"]} au {$trip["end_date"]}</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>Vous n'avez pas encore acheté de barathon.</p>";
}

// Paiements réalisés
echo "<h3>💳 Vos paiements enregistrés :</h3>";
$userPayments = array_filter($payments, function($payment) use ($login) {
    return $payment["user"] === $login;
});

if (!empty($userPayments)) {
    echo "<ul>";
    foreach ($userPayments as $pay) {
        echo "<li>Transaction <strong>{$pay["transaction_id"]}</strong> - Montant : {$pay["amount"]} € - Date : {$pay["payment_date"]}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun paiement effectué pour l'instant.</p>";
}
?>
