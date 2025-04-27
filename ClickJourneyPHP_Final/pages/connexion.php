<?php
session_start();
include '../partials/header.php';

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation des entrées
    $login = htmlspecialchars($_POST["login"]);
    $password = $_POST["password"];

    // Chargement du fichier JSON contenant les utilisateurs
    $file = "../db/users.json";
    if (!file_exists($file)) {
        $error = "Aucun utilisateur inscrit.";
    } else {
        $users = json_decode(file_get_contents($file), true);
        foreach ($users as &$user) {
            // Vérification de l'identifiant et du mot de passe
            if ($user["login"] === $login && password_verify($password, $user["password"])) {
                // Démarrage de la session
                $_SESSION["login"] = $login;
                $_SESSION["role"] = $user["role"];
                $_SESSION["pseudo"] = $user["pseudo"];

                // Mise à jour de la dernière connexion
                $user["last_login"] = date("Y-m-d H:i:s");
                file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

                // Redirection vers le profil
                header("Location: profil.php");
                exit;
            }
        }
        $error = "Identifiants incorrects.";
    }
}
?>

<div class="main-container">
    <h1>Connexion</h1>

    <?php if (isset($error)) echo "<p style='color:red;'>" . $error . "</p>"; ?>
    <?php if (isset($_GET['success'])) echo "<p style='color:green;'>Inscription réussie. Vous pouvez vous connecter.</p>"; ?>

    <!-- Formulaire de connexion -->
    <form method="POST">
        <label for="login">Identifiant</label>
        <input type="text" id="login" name="login" placeholder="Votre login" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

        <button type="submit">Se connecter</button>
    </form>
</div>
