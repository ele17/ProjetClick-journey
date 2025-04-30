<?php
session_start();
include 'header.php';

// Vérification que l'utilisateur est connecté et est administrateur
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

// Chargement de tous les utilisateurs
$users = json_decode(file_get_contents("../db/users.json"), true);
?>

<div class="main-container">
    <h1>Panneau d'administration</h1>

    <h2>Liste des utilisateurs inscrits</h2>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; text-align:left; background-color:#2c2533; color:white;">
        <thead style="background-color:#3d0d3a;">
            <tr>
                <th>Identifiant</th>
                <th>Pseudo</th>
                <th>Nom</th>
                <th>Rôle</th>
                <th>Inscrit le</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['login']) ?></td>
                <td><?= htmlspecialchars($user['pseudo']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= htmlspecialchars($user['registered_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
