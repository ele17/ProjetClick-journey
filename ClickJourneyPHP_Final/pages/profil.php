<?php
session_start();
include '../partials/header.php';

// Vérification de la connexion utilisateur
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit;
}

// Chargement des données utilisateur depuis users.json
$file = "../db/users.json";
$users = json_decode(file_get_contents($file), true);

// Recherche de l'utilisateur actuellement connecté
$currentUser = null;
foreach ($users as $user) {
    if ($user["login"] === $_SESSION["login"]) {
        $currentUser = $user;
        break;
    }
}

// Si l'utilisateur est introuvable
if (!$currentUser) {
    echo "<div class='main-container'><p style='color:red;'>Utilisateur non trouvé.</p></div>";
    exit;
}
?>

<div class="main-container">
    <h1>Bienvenue, <?= htmlspecialchars($currentUser["pseudo"]) ?> 👋</h1>

    <h2>Vos informations personnelles</h2>
    <ul>
        <li><strong>Nom :</strong> <?= htmlspecialchars($currentUser["name"]) ?></li>
        <li><strong>Identifiant :</strong> <?= htmlspecialchars($currentUser["login"]) ?></li>
        <li><strong>Adresse :</strong> <?= htmlspecialchars($currentUser["address"]) ?></li>
        <li><strong>Date de naissance :</strong> <?= htmlspecialchars($currentUser["birthdate"]) ?></li>
        <li><strong>Inscription :</strong> <?= htmlspecialchars($currentUser["registered_at"]) ?></li>
        <li><strong>Dernière connexion :</strong> <?= htmlspecialchars($currentUser["last_login"]) ?></li>
    </ul>
</div>
