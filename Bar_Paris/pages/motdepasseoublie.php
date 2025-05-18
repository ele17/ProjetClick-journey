<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $utilisateurs = json_decode(file_get_contents("../db/users.json"), true);
    
    foreach ($utilisateurs as $user) {
        if ($user['login'] === $login) {
            header("Location: reinitialisermotdepasse.php?login=" . urlencode($login));
            exit;
        }
    }
    $erreur = "Aucun utilisateur trouvé avec cet email.";
}
?>

<h2>🔐 Mot de passe oublié</h2>
<form method="POST">
    <label for="login">Votre email :</label><br>
    <input type="login" name="login" required><br><br>
    <input type="submit" value="Envoyer le lien de réinitialisation">
</form>

<?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>

