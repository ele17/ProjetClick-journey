<?php
$login = $_GET['login'] ?? null;

if (!$login) {
    echo "Lien invalide (aucun email transmis).";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nouveau = $_POST['nouveau'];
    $users = json_decode(file_get_contents("../db/users.json"), true);
    $updated = false;

    foreach ($users as &$user) {
        if ($user['login'] === $login) {
            $user['password'] = password_hash($nouveau, PASSWORD_DEFAULT);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents("../db/users.json", json_encode($users, JSON_PRETTY_PRINT));
        header("Location: connexion.php?reset=success");
        exit;
    } else {
        $erreur = "Utilisateur non trouvé.";
    }
}
?>

<h2>🔁 Réinitialiser votre mot de passe</h2>
<form method="POST">
    <label for="nouveau">Nouveau mot de passe :</label><br>
    <input type="password" name="nouveau" required><br><br>
    <input type="submit" value="Réinitialiser">
</form>

<?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
