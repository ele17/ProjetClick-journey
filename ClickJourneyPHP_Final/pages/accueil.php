<?php
session_start();
include '../partials/header.php';

// Chargement des circuits depuis le fichier JSON
$parcours = json_decode(file_get_contents("../db/parcours.json"), true);

?>

<div class="main-container">
    <h1> Bienvenue sur ClickJourney — vos barathons à Paris</h1>

    <h3> Découvrez nos circuits à thème :</h3>

    <?php if (!$parcours): ?>
        <p> Erreur de chargement des circuits. Veuillez réessayer plus tard.</p>
    <?php else: ?>
        <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
            <?php foreach (array_slice($parcours, 0, 3) as $circuit): ?>
                <div style="border:1px solid #ccc; padding:10px; width:280px; border-radius:8px; background-color:#2c2533;">
                    <h4><?= htmlspecialchars($circuit['titre']) ?></h4>
                    <p><strong>Résumé :</strong> <?= htmlspecialchars($circuit['resume']) ?></p>
                    <p> <?= htmlspecialchars($circuit['duree']) ?> | <?= htmlspecialchars($circuit['prix']) ?></p>
                    <a href="circuits.php" style="color:#ff99cc;">Voir ce circuit</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
