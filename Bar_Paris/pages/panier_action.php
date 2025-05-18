
<?php
session_start();

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Traitement du formulaire POST depuis circuits.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $circuit_id = $_POST['circuit_id'] ?? null;
    $options = $_POST['options'] ?? [];

    if ($circuit_id) {
        // Ajouter au panier avec options
        $_SESSION['panier'][] = [
            'id' => $circuit_id,
            'options' => $options
        ];
    }

    header("Location: panier.php");
    exit;
}

// Gestion suppression via GET
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Supprimer une ligne précise (par index)
    if ($action === 'supprimer' && isset($_GET['index'])) {
        $index = intval($_GET['index']);
        if (isset($_SESSION['panier'][$index])) {
            unset($_SESSION['panier'][$index]);
            $_SESSION['panier'] = array_values($_SESSION['panier']); // Re-index
        }
    }

    // Vider tout le panier
    if ($action === 'vider') {
        $_SESSION['panier'] = [];
    }

    header("Location: panier.php");
    exit;
}
?>