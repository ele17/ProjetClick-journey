<?php
session_start();
include 'header.php';

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sécurisation des entrées
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    // Chargement du fichier JSON contenant les utilisateurs
    $file = "../db/users.json";
    if (!file_exists($file)) {
        $error = "Aucun utilisateur inscrit.";
    } else {
        $users = json_decode(file_get_contents($file), true);
        foreach ($users as &$user) {
            // Vérification de l'identifiant et du mot de passe
            if ($user['login'] === $login && password_verify($password, $user['password'])) {
                // Démarrage de la session
                $_SESSION["login"] = $login;
                $_SESSION["role"] = $user["role"];
                $_SESSION["pseudo"] = $user["pseudo"];

                // Initialiser la session utilisateur
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'login' => $user['login'],
                    'prenom' => $user['pseudo'],
                    'role' => $user['role']
                ];

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
    <label for="login">Identifiant (ou email) :</label><br>
    <input type="text" name="login" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Se connecter">
</form>


<!-- Lien de mot de passe oublié -->
<p><a href="motdepasseoublie.php" style="color:#ff99cc;">Mot de passe oublié ?</a></p>

<?php include 'footer.php'; ?>