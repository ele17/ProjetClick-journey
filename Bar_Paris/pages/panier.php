
<?php
session_start();
include 'header.php';

$parcours = json_decode(file_get_contents("../db/parcours.json"), true);
$options_all = json_decode(file_get_contents("../db/options.json"), true);

// Reformatage des options en tableau indexé par ID avec nom et prix
$options_map = [];
foreach ($options_all as $opt) {
    $options_map[$opt['id']] = ['nom' => $opt['nom'], 'prix' => floatval($opt['prix'] ?? 0)];
}

$panier = $_SESSION['panier'] ?? [];
$total = 0;
?>

<div class="main-container">
    <h1>Votre panier</h1>

    <style>
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 1em auto;
            padding: 1em;
            max-width: 600px;
            text-align: left;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin: 0.2em 0;
            color: #ff6f61;
        }
        .card p {
            margin: 0.2em 0;
            color: #444;
        }
        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #ff6f61;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .button:hover {
            background-color: #e85c50;
        }
        .total {
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            margin-top: 2em;
        }
    </style>

    <?php if (empty($panier)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <?php foreach ($panier as $index => $item): ?>
            <?php
                $circuit = array_filter($parcours, fn($p) => $p['id'] === $item['id']);
                $circuit = array_shift($circuit);
                if (!$circuit) continue;

                $prix_str = str_replace('€', '', $circuit['prix']);
                $prix_circuit = floatval($prix_str);
                $prix_options = 0;
            ?>
            <div class="card">
                <h2><?= htmlspecialchars($circuit['titre']) ?> - <?= number_format($prix_circuit, 2) ?> €</h2>
                <?php if (!empty($item['options'])): ?>
                    <p><strong>Options choisies :</strong></p>
                    <ul>
                        <?php foreach ($item['options'] as $opt_id): ?>
                            <?php
                                $opt_nom = $options_map[$opt_id]['nom'] ?? $opt_id;
                                $opt_prix = $options_map[$opt_id]['prix'] ?? 0;
                                $prix_options += $opt_prix;
                            ?>
                            <li><?= htmlspecialchars($opt_nom) ?> (<?= number_format($opt_prix, 2) ?> €)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p><em>Aucune option sélectionnée.</em></p>
                <?php endif; ?>
                <p><strong>Total pour ce circuit :</strong> <?= number_format($prix_circuit + $prix_options, 2) ?> €</p>
                <a class="button" href="panier_action.php?action=supprimer&index=<?= $index ?>">Retirer</a>
            </div>
            <?php $total += $prix_circuit + $prix_options; ?>
        <?php endforeach; ?>

        <div class="total">Total général : <?= number_format($total, 2) ?> €</div>
        <div style="text-align: center; margin-top: 20px;">
            <a class="button" href="paiement.php">Procéder au paiement</a>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            
        </div>


        <a class="button" href="panier_action.php?action=vider">Vider le panier</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>