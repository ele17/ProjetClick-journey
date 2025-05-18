
<?php
session_start();
include 'header.php';

if (!isset($_SESSION['user'])) {
    echo "<div class='main-container'><p>Veuillez vous <a href='connexion.php'>connecter</a> pour voir votre profil.</p></div>";
    exit;
}

$user_id = $_SESSION['user']['id'];
$users_file = "../db/users.json";
$achats = [];

if (file_exists($users_file)) {
    $users_data = json_decode(file_get_contents($users_file), true);
    foreach ($users_data as $u) {
        if ($u['id'] === $user_id && isset($u['achats'])) {
            $achats = $u['achats'];
            break;
        }
    }
}
?>

<div class="main-container">
    <h1>Profil de <?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'Utilisateur') ?></h1>

    <h2>Historique des achats</h2>

    <?php if (empty($achats)): ?>
        <p>Vous n'avez encore rien acheté.</p>
    <?php else: ?>
        <?php foreach ($achats as $achat): ?>
            <div class="card">
                <p><strong>Date :</strong> <?= htmlspecialchars($achat['date']) ?></p>
                <?php foreach ($achat['commande'] as $circuit): ?>
                    <p><strong>Circuit :</strong> <?= htmlspecialchars($circuit['id']) ?></p>
                    <?php if (!empty($circuit['options'])): ?>
                        <p><strong>Options :</strong> <?= implode(', ', array_map('htmlspecialchars', $circuit['options'])) ?></p>
                    <?php else: ?>
                        <p><em>Aucune option sélectionnée.</em></p>
                    <?php endif; ?>
                    <hr>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>