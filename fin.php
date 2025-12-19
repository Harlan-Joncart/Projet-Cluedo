<?php
session_start();
include 'includes/connexion.php';
include 'includes/fonction.php';

if (!isset($_SESSION['solution'])) {
    header("Location: index.php");
    exit;
}

$solution_p = getPersonnageById($sqlite, $_SESSION['solution']['personnage']);
$solution_a = getArmeById($sqlite, $_SESSION['solution']['arme']);
$solution_l = getPieceById($sqlite, $_SESSION['solution']['piece']);

$nb_deplacements = $_SESSION['nb_pieces_visitees'];
$nb_hypotheses = $_SESSION['nb_hypotheses'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fin de la partie</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h1>🎉 Victoire !</h1>

<h2>Solution</h2>
<ul>
    <li>Meurtrier : <?= htmlspecialchars($solution_p['nom_personnage']) ?></li>
    <li>Arme : <?= htmlspecialchars($solution_a['nom_arme']) ?></li>
    <li>Pièce : <?= htmlspecialchars($solution_l['nom_piece']) ?></li>
</ul>

<h2>Statistiques</h2>
<ul>
    <li>Déplacements : <?= $nb_deplacements ?></li>
    <li>Hypothèses : <?= $nb_hypotheses ?></li>
</ul>

<form action="index.php" method="get">
    <button type="submit" name="new" value="1">Rejouer</button>
</form>

</body>
</html>
