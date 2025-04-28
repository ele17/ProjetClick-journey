<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: connexion.php");
    exit;
}

if (!isset($_POST["trip_id"])) {
    echo "Aucun barathon sélectionné.";
    exit;
}

$tripId = intval($_POST["trip_id"]);
$trips = json_decode(file_get_contents("../data/trips.json"), true);
$steps = json_decode(file_get_contents("../data/steps.json"), true);
$options = json_decode(file_get_contents("../data/options.json"), true);

// Récupération du trip sélectionné
foreach ($trips as $trip) {
    if ($trip["id"] == $tripId) {
        $selectedTrip = $trip;
        break;
    }
}

echo "<h2> Récapitulatif du barathon : {$selectedTrip["title"]}</h2>";
echo "<p> Du {$selectedTrip["start_date"]} au {$selectedTrip["end_date"]}</p>";

$total_price = 0;

foreach ($selectedTrip["steps"] as $stepId) {
    foreach ($steps as $step) {
        if ($step["id"] == $stepId) {
            echo "<h3> Étape : {$step["title"]}</h3>";
            foreach ($step["options"] as $optId) {
                foreach ($options as $opt) {
                    if ($opt["id"] == $optId) {
                        $chosen_value = $_POST["option_{$optId}"];
                        $nb_personnes = intval($_POST["nb_{$optId}"]);

                        $prix = $nb_personnes * $opt["price_per_person"];
                        $total_price += $prix;

                        echo "<p> Option <strong>{$opt["type"]}</strong> : <em>$chosen_value</em> pour $nb_personnes personnes ( $prix €)</p>";
                    }
                }
            }
            echo "<hr>";
        }
    }
}

echo "<h3> Total personnalisé : $total_price €</h3>";
?>

<form method="POST" action="paiement.php">
    <input type="hidden" name="trip_id" value="<?= $tripId ?>">
    <input type="hidden" name="total_price" value="<?= $total_price ?>">
    <button type="submit"> Procéder au paiement</button>
</form>

<br>
<form action="detail.php" method="GET">
    <input type="hidden" name="id" value="<?= $tripId ?>">
    <button type="submit"> Modifier les options</button>
</form>
