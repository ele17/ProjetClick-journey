<?php
session_start();
include 'header.php';

// Charger les données des parcours
$parcours = json_decode(file_get_contents("../db/parcours.json"), true);

$panier = $_SESSION['panier'] ?? [];
?>

<div class="main-container">
    <h1>Votre panier</h1>

    <?php if (empty($panier)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <?php foreach ($panier as $id => $quantite): ?>
            <?php
                $circuit = array_filter($parcours, fn($p) => $p['id'] == $id);
                $circuit = array_shift($circuit);
            ?>
            <div style="margin-bottom: 1.5em; border: 1px solid #ccc; padding: 1em; border-radius: 8px; background-color: #2c2533;">
                <h2><?= htmlspecialchars($circuit['titre']) ?></h2>
                <p><?= htmlspecialchars($circuit['resume']) ?></p>
                <p>Durée : <?= htmlspecialchars($circuit['duree']) ?> | Prix : <?= htmlspecialchars($circuit['prix']) ?> </p>
                <p>Quantité : <?= $quantite ?></p>

                <!-- Formulaire pour modifier la quantité -->
                <form action="modifierpanier.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="number" name="quantite" min="1" value="<?= $quantite ?>" required>
                    <button type="submit">Modifier</button>
                </form>

                <!-- Formulaire pour supprimer l'article -->
                <form action="supprimerpanier.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>

        <?php
            $total = 0;
            foreach ($panier as $id => $quantite) {
                $circuit = array_filter($parcours, fn($p) => $p['id'] == $id);
                $circuit = array_shift($circuit);
                $prix = floatval($circuit['prix']); // conversion sécurisée
                $total += $prix * $quantite;
            }
        ?>
        <h3>Total : <?= $total ?> €</h3>
    <?php endif; ?>
</div>
