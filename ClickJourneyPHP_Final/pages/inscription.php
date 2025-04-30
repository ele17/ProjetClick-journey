<?php
session_start();
include 'header.php';

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation des champs
    $login = htmlspecialchars($_POST["login"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $name = htmlspecialchars($_POST["name"]);
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $birthdate = htmlspecialchars($_POST["birthdate"]);
    $address = htmlspecialchars($_POST["address"]);
    $role = "normal"; // Tous les nouveaux utilisateurs sont de rôle "normal"
    $registered_at = date("Y-m-d");

    $file = "../db/users.json";
    $users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    // Vérifier si le login est déjà utilisé
    foreach ($users as $user) {
        if ($user["login"] === $login) {
            $error = "Ce login est déjà utilisé.";
            break;
        }
    }

    // Si aucun doublon détecté, on crée le nouvel utilisateur
    if (!isset($error)) {
        $newUser = [
            "login" => $login,
            "password" => $password,
            "role" => $role,
            "name" => $name,
            "pseudo" => $pseudo,
            "birthdate" => $birthdate,
            "address" => $address,
            "registered_at" => $registered_at,
            "last_login" => "",
            "viewed_trips" => [],
            "purchased_trips" => []
        ];

        $users[] = $newUser;
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

        // Redirection vers la page de connexion
        header("Location: connexion.php?success=1");
        exit;
    }
}
?>

<div class="main-container">
    <h1>Inscription</h1>

    <?php if (isset($error)) echo "<p style='color:red;'>" . $error . "</p>"; ?>

    <!-- Formulaire d'inscription -->
    <form method="POST">
        <label for="login">Identifiant</label>
        <input type="text" id="login" name="login" placeholder="Votre login" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>

        <label for="name">Nom complet</label>
        <input type="text" id="name" name="name" placeholder="Nom complet" required>

        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo public" required>

        <label for="birthdate">Date de naissance</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="address">Adresse</label>
        <input type="text" id="address" name="address" placeholder="Adresse postale" required>

        <button type="submit">S'inscrire</button>
    </form>
</div>
