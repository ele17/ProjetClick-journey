<?php
session_start();

// Vérifier la connexion de l'utilisateur
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php?message=connectez-vous-pour-payer");
    exit;
}
require('getapikey.php');
include 'header.php';

// Charger les données nécessaires
$fichier = "../db/parcours.json";
if (!file_exists($fichier)) {
    die("Fichier manquant : $fichier");
}
$parcours = json_decode(file_get_contents($fichier), true);
if (!is_array($parcours)) {
    die("Erreur lors du chargement des parcours.");
}

$panier = $_SESSION['panier'] ?? [];
$total = 0;

// Si le panier est vide, on affiche un message
if (empty($panier)) {
    echo "<div class='main-container'><p>Votre panier est vide. <a href='accueil.php'>Retour à l'accueil</a></p></div>";
    exit;
}

// Calcul dynamique du montant total
foreach ($panier as $item) {
    $id = $item['id'];
    $circuit = array_filter($parcours, fn($p) => $p['id'] == $id);
    $circuit = array_shift($circuit);
    if ($circuit && isset($circuit['prix'])) {
        $total += floatval($circuit['prix']);
    }
}

// Préparation des données pour CYBank
$montant = number_format((float)$total, 2, '.', '');
$transaction = uniqid();
$vendeur = 'MIM_F';
$retour = "http://localhost/PHPtest/ClickJourneyPHP4/ClickJourneyPHP/pages/retourpaiement.php";
$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
</head>
<body>
    <div class="main-container">
        <h2>Récapitulatif du paiement</h2>

        <?php foreach ($panier as $item): ?>
            <?php
                $id = $item['id'];
                $circuit = array_filter($parcours, fn($p) => $p['id'] == $id);
                $circuit = array_shift($circuit);
                if (!$circuit) continue;
            ?>
            <div style="margin-bottom: 1em; padding: 1em; background-color:rgb(109, 78, 139); border-radius: 8px;">
                <h3><?= htmlspecialchars($circuit['titre']) ?></h3>
                <p><?= htmlspecialchars($circuit['resume']) ?></p>
                <p>Prix : <?= htmlspecialchars($circuit['prix']) ?> €</p>
            </div>
        <?php endforeach; ?>

        <p><strong>Total à payer :</strong> <?= htmlspecialchars($montant) ?> € </p>

        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction) ?>">
            <input type="hidden" name="montant" value="<?= htmlspecialchars($montant) ?>">
            <input type="hidden" name="vendeur" value="<?= htmlspecialchars($vendeur) ?>">
            <input type="hidden" name="retour" value="<?= htmlspecialchars($retour) ?>">
            <input type="hidden" name="control" value="<?= htmlspecialchars($control) ?>">
            <input type="submit" value="Payer maintenant" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
