<?php
session_start();
include '../partials/header.php';
?>

<div class="main-container">
    <h1>Nos circuits Barathon à Paris</h1>
    <p>Découvrez nos parcours de bars à thème : cocktails, bars cachés, cabaret... et bien plus !</p>

    <?php
    // Chargement des données JSON
    $parcours = json_decode(file_get_contents("../db/parcours.json"), true);
    $etapes = json_decode(file_get_contents("../db/etapes.json"), true);
    $options = json_decode(file_get_contents("../db/options.json"), true);

    if (!$parcours || !$etapes) {
        echo "<p style='color:red;'>Erreur de chargement des circuits. Veuillez réessayer plus tard.</p>";
        exit;
    }

    // Affichage de chaque circuit
    foreach ($parcours as $circuit):
    ?>
        <div style="margin-bottom: 2em; padding: 1em; border: 1px solid #ccc; border-radius: 8px; background-color: #2c2533;">
            <h2><?= htmlspecialchars($circuit['titre']) ?></h2>
            <p><strong>Résumé :</strong> <?= htmlspecialchars($circuit['resume']) ?></p>
            <p>
                Durée : <?= htmlspecialchars($circuit['duree']) ?> |
                Difficulté : <?= htmlspecialchars($circuit['difficulte']) ?> |
                Prix : <?= htmlspecialchars($circuit['prix']) ?>
            </p>

            <!-- Affichage des étapes liées à ce circuit -->
            <h3>Étapes du parcours :</h3>
            <ul>
            <?php foreach ($etapes as $etape): ?>
                <?php if ($etape['circuit_id'] === $circuit['id']): ?>
                    <li><strong><?= htmlspecialchars($etape['nom']) ?></strong> — <?= htmlspecialchars($etape['adresse']) ?> (Note : <?= htmlspecialchars($etape['note']) ?>)</li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>

            <!-- Liste des options globales -->
            <h4>Options disponibles :</h4>
            <ul>
                <?php foreach ($options as $opt): ?>
                    <li><?= htmlspecialchars($opt['nom']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>
