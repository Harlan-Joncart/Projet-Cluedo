<?php
session_start();

// Si le joueur clique sur "Commencer une nouvelle partie"
if (isset($_GET['new'])) {
    session_destroy();
    header("Location: jeu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cluedo Web</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h1>Bienvenue dans le Cluedo Web</h1>

<p>Le but du jeu est de découvrir :</p>
<ul>
    <li>le meurtrier</li>
    <li>l’arme utilisée</li>
    <li>la pièce du crime</li>
</ul>

<p>Déplacez-vous dans le manoir et formulez des hypothèses pour résoudre l’enquête.</p>

<form method="get">
    <button type="submit" name="new" value="1">Commencer une nouvelle partie</button>
</form>

</body>
</html>
