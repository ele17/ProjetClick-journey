<?php
session_start(); // Démarrage de la session
?>
<link rel="stylesheet" href="/ClickJourneyPHP/style.css">

<div class="header-container">
    <h1>ClickJourney</h1>
</div>

<nav class="nav-container">
    <ul>
        <li><a href="/ClickJourneyPHP/pages/accueil.php">Accueil</a></li>

        <?php if (isset($_SESSION['login'])): ?>
            <li><a href="/ClickJourneyPHP/pages/profil.php">Profil</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="/ClickJourneyPHP/pages/admin.php">Admin</a></li>
            <?php endif; ?>
            <li><a href="/ClickJourneyPHP/pages/logout.php">Déconnexion</a></li>
            <li>👋 Bienvenue, <?= htmlspecialchars($_SESSION['pseudo']) ?></li>
        <?php else: ?>
            <li><a href="/ClickJourneyPHP/pages/connexion.php">Connexion</a></li>
            <li><a href="/ClickJourneyPHP/pages/inscription.php">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>
