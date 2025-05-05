<?php
?>
<link rel="stylesheet" href="../style.css">

<div class="header-container">
    <h1>ClickJourney</h1>
</div>

<nav class="nav-container">
    <ul>
        <li><a href="accueil.php">Accueil</a></li>

        <?php if (isset($_SESSION['login'])): ?>
            <li><a href="profil.php">Profil</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Déconnexion</a></li>
            <li> Bienvenue, <?= htmlspecialchars($_SESSION['pseudo']) ?></li>
        <?php else: ?>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="paiement.php">Passez au paiement</a></li>
        <?php endif; ?>
    </ul>
</nav>
