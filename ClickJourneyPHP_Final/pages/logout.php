<?php
// Démarrage de la session pour pouvoir la détruire
session_start();

// Suppression de toutes les variables de session
session_unset();

// Destruction complète de la session
session_destroy();

// Redirection vers la page de connexion
header("Location: connexion.php");
exit();
?>
