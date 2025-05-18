<?php
session_start();
include 'header.php';
?>

<div class="main-container">
    <h1>Nos circuits Barathon à Paris</h1>
    <p>Découvrez nos parcours de bars à thème : cocktails, bars cachés, cabaret... et bien plus !</p>

    <?php
    $parcours = json_decode(file_get_contents("../db/parcours.json"), true);
    $etapes = json_decode(file_get_contents("../db/etapes.json"), true);

    if (!$parcours || !$etapes) {
        echo "<p style='color:red;'>Erreur de chargement des circuits. Veuillez réessayer plus tard.</p>";
        exit;
    }

    foreach ($parcours as $circuit) {
        // Étapes associées à ce circuit
        $etapes_du_circuit = array_filter($etapes, fn($e) => $e['circuit_id'] === $circuit['id']);

        // Image aléatoire si étapes dispo
        $image_url = '';
        $alt_text = 'Illustration du circuit';
        if (!empty($etapes_du_circuit)) {
            $etape_aleatoire = $etapes_du_circuit[array_rand($etapes_du_circuit)];
            $image_url = htmlspecialchars($etape_aleatoire['image_url']);
            $alt_text = 'Image de ' . htmlspecialchars($etape_aleatoire['nom']);
        }
    ?>
        <div class="card">
    <div class="circuit-image">
        <?php if ($image_url): ?>
            <img src="<?= $image_url ?>" alt="<?= $alt_text ?>">
        <?php endif; ?>
    </div>
    <div class="card-content">
        <h3><?= htmlspecialchars($circuit['titre']) ?></h3>
        <p><?= htmlspecialchars($circuit['resume']) ?></p>
        <a href="circuits.php?id=<?= urlencode($circuit['id']) ?>" class="button-link">Voir le détail</a>
    </div>
</div>
    <?php
    }
    ?>
</div>

<?php include 'footer.php'; ?>
