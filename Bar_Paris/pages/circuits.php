
<?php
session_start();
include 'header.php';
?>

<div class="main-container">
    <h1>Nos circuits Barathon à Paris</h1>
    <p>Découvrez nos parcours de bars à thème : cocktails, bars cachés, cabaret... et bien plus !</p>

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
        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 1em;
        }
        .card h2 {
            margin: 0.2em 0;
            color: #ff6f61;
        }
        .card p {
            margin: 0.2em 0;
            color: #444;
        }
        .card form {
            margin-top: 10px;
        }
        .card .button {
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
        .card .button:hover {
            background-color: #e85c50;
        }
        .options {
            margin-top: 10px;
        }
        .options label {
            display: block;
            font-size: 0.95em;
            margin: 5px 0;
        }
    </style>

    <?php
    $parcours = json_decode(file_get_contents("../db/parcours.json"), true);
    $etapes = json_decode(file_get_contents("../db/etapes.json"), true);
    $options = json_decode(file_get_contents("../db/options.json"), true);

    if (!$parcours || !$etapes) {
        echo "<p style='color:red;'>Erreur de chargement des circuits. Veuillez réessayer plus tard.</p>";
        exit;
    }

    function afficher_circuit($circuit, $etapes_du_circuit, $options, $show_button = false) {
        $image_url = '';
        $alt_text = 'Illustration du circuit';
        if (!empty($etapes_du_circuit)) {
            $etape_aleatoire = $etapes_du_circuit[array_rand($etapes_du_circuit)];
            $image_url = htmlspecialchars($etape_aleatoire['image_url']);
            $alt_text = htmlspecialchars($etape_aleatoire['nom']);
        }

        echo "<div class='card'>";
        if (!empty($image_url)) {
            echo "<img src='$image_url' alt='$alt_text'>";
        }
        echo "<h2>" . htmlspecialchars($circuit['nom']) . "</h2>";
        echo "<p><strong>Nombre d'étapes :</strong> " . count($etapes_du_circuit) . "</p>";
        echo "<p><strong>Options :</strong></p>";
        echo "<form action='panier_action.php' method='post'>";
        echo "<input type='hidden' name='circuit_id' value='" . htmlspecialchars($circuit['id']) . "'>";
        echo "<div class='options'>";
        foreach ($options as $opt) {
            echo "<label><input type='checkbox' name='options[]' value='" . htmlspecialchars($opt['id']) . "'> " . htmlspecialchars($opt['nom']) . "</label>";
        }
        echo "</div>";
        echo "<button class='button' type='submit'>Ajouter au panier</button>";
        echo "</form>";

        if ($show_button) {
            echo "<a class='button' href='?id=" . urlencode($circuit['id']) . "'>Voir ce circuit</a>";
        }
        echo "</div>";
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $circuit_trouve = null;
        foreach ($parcours as $c) {
            if ($c['id'] === $id) {
                $circuit_trouve = $c;
                break;
            }
        }

        if ($circuit_trouve) {
            $etapes_du_circuit = array_filter($etapes, fn($e) => $e['circuit_id'] === $circuit_trouve['id']);
            afficher_circuit($circuit_trouve, $etapes_du_circuit, $options, false);
        } else {
            echo "<p style='color:red;'>Circuit non trouvé.</p>";
        }

    } else {
        foreach ($parcours as $circuit) {
            $etapes_du_circuit = array_filter($etapes, fn($e) => $e['circuit_id'] === $circuit['id']);
            afficher_circuit($circuit, $etapes_du_circuit, $options, true);
        }
    }
    ?>
</div>

<?php include 'footer.php'; ?>