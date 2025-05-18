
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ClickJourney</title>
    <link id="theme-css" rel="stylesheet" href="../css/dark.css">
    <script src="../js/theme.js" defer></script>
</head>
<body>

<button id="toggle-theme">Changer de thème</button>

<div class="header-container">
    <h1>ClickJourney</h1>
</div>

<nav class="nav-container">
    <ul>
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="circuits.php">Circuits</a></li>
        <li><a href="panier.php">Panier</a></li>

        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
            <li>Bienvenue, <?= htmlspecialchars($_SESSION['user']['prenom']) ?></li>
        <?php else: ?>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>