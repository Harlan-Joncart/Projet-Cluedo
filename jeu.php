<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'includes/connexion.php';
include 'includes/fonction.php';

/* ================================
   1. Initialisation de la partie
================================ */
if (!isset($_SESSION["solution"])) {

    $_SESSION["solution"] = genererCombinaisonSecrete($sqlite);

    $depart = getDepart($sqlite);
    $_SESSION["piece_actuelle"] = $depart["id_piece"];

    $_SESSION["nb_hypotheses"] = 0;
    $_SESSION["nb_pieces_visitees"] = 1;
    $_SESSION["derniere_hypothese_piece"] = null;
}

/* ================================
   2. Déplacement
================================ */
if (isset($_GET["move"])) {

    $destination = (int)$_GET["move"];
    $adj = getAdjacentes($sqlite, $_SESSION["piece_actuelle"]);
    $estAdjacente = false;
    $nomDestination = "";

    while ($p = $adj->fetchArray(SQLITE3_ASSOC)) {
        if ($p["id_piece"] == $destination) {
            $estAdjacente = true;
            $nomDestination = $p["nom_piece"];
            break;
        }
    }

    if ($estAdjacente) {
        $_SESSION["piece_actuelle"] = $destination;
        $_SESSION["nb_pieces_visitees"]++;
        $_SESSION["message"] = "Vous vous déplacez vers $nomDestination.";
    } else {
        $_SESSION["message"] = "Déplacement interdit.";
    }
}

/* ================================
   3. Hypothèse
================================ */
if (isset($_POST["pers"], $_POST["arme"], $_POST["piece"])) {

    if (!peutFaireHypothese($_SESSION["piece_actuelle"])) {
        $_SESSION["message"] = "Impossible : hypothèse déjà faite dans cette pièce.";
    } else {

        $resultat = verifierHypothese(
            (int)$_POST["pers"],
            (int)$_POST["arme"],
            (int)$_POST["piece"]
        );

        $_SESSION["nb_hypotheses"]++;
        $_SESSION["derniere_hypothese_piece"] = $_SESSION["piece_actuelle"];

        if ($resultat === "gagne") {
            header("Location: fin.php");
            exit;
        } else {
            $_SESSION["message"] = "Indice : l’élément incorrect est le $resultat.";
        }
    }
}

/* ================================
   4. Affichage
================================ */
$id_piece = $_SESSION["piece_actuelle"];
$pieceActuelle = getPieceById($sqlite, $id_piece);
$adjacentes = getAdjacentes($sqlite, $id_piece);
$listePers = getPersonnages($sqlite);
$listeArmes = getArmes($sqlite);
$listePieces = getPieces($sqlite);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cluedo – Jeu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h1>Vous êtes dans : <?= htmlspecialchars($pieceActuelle["nom_piece"]) ?></h1>

<?php if (isset($_SESSION["message"])): ?>
    <p style="color:red;"><strong><?= $_SESSION["message"] ?></strong></p>
    <?php unset($_SESSION["message"]); ?>
<?php endif; ?>

<h2>Déplacements possibles</h2>
<ul>
<?php while ($p = $adjacentes->fetchArray(SQLITE3_ASSOC)): ?>
    <li><a href="?move=<?= $p["id_piece"] ?>">Aller dans <?= htmlspecialchars($p["nom_piece"]) ?></a></li>
<?php endwhile; ?>
</ul>

<hr>

<h2>Formuler une hypothèse</h2>

<?php if (peutFaireHypothese($id_piece)): ?>
<form method="post">

<select name="pers">
<?php while ($p = $listePers->fetchArray(SQLITE3_ASSOC)): ?>
    <option value="<?= $p["id_personnage"] ?>"><?= htmlspecialchars($p["nom_personnage"]) ?></option>
<?php endwhile; ?>
</select>

<select name="arme">
<?php while ($a = $listeArmes->fetchArray(SQLITE3_ASSOC)): ?>
    <option value="<?= $a["id_arme"] ?>"><?= htmlspecialchars($a["nom_arme"]) ?></option>
<?php endwhile; ?>
</select>

<select name="piece">
<?php while ($pi = $listePieces->fetchArray(SQLITE3_ASSOC)): ?>
    <option value="<?= $pi["id_piece"] ?>"><?= htmlspecialchars($pi["nom_piece"]) ?></option>
<?php endwhile; ?>
</select>

<br><br>
<button type="submit">Valider l’hypothèse</button>
</form>
<?php else: ?>
<p style="color:gray;">Hypothèse déjà faite ici.</p>
<?php endif; ?>

<hr>

<p><a href="index.php">Abandonner la partie</a></p>

</body>
</html>
