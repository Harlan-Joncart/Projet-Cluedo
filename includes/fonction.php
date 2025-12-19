<?php
function getDepart($sqlite) {
    $sql = "SELECT * FROM pieces WHERE nom_piece = 'Hall' LIMIT 1";
    return $sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
}

function getPersonnages($sqlite) {
    $sql = "SELECT * FROM personnages";
    return $sqlite->query($sql);
}

function getArmes($sqlite) {
    $sql = "SELECT * FROM armes";
    return $sqlite->query($sql);
}

function getPieces($sqlite) {
    $sql = "SELECT * FROM pieces";
    return $sqlite->query($sql);
}

function getAdjacentes($sqlite, $id_piece) {
    $sql = "
        SELECT pieces.* FROM portes
        JOIN pieces ON pieces.id_piece = portes.id_piece2
        WHERE portes.id_piece1 = $id_piece
        UNION
        SELECT pieces.* FROM portes
        JOIN pieces ON pieces.id_piece = portes.id_piece1
        WHERE portes.id_piece2 = $id_piece
    ";
    return $sqlite->query($sql);
}

function genererCombinaisonSecrete($sqlite) {
    $pers = $sqlite->query("SELECT id_personnage FROM personnages ORDER BY RANDOM() LIMIT 1")->fetchArray(SQLITE3_ASSOC);
    $arme = $sqlite->query("SELECT id_arme FROM armes ORDER BY RANDOM() LIMIT 1")->fetchArray(SQLITE3_ASSOC);
    $piece = $sqlite->query("SELECT id_piece FROM pieces ORDER BY RANDOM() LIMIT 1")->fetchArray(SQLITE3_ASSOC);

    return [
        "personnage" => $pers["id_personnage"],
        "arme" => $arme["id_arme"],
        "piece" => $piece["id_piece"]
    ];
}

function verifierHypothese($hyp_pers, $hyp_arme, $hyp_piece) {

    $solution = $_SESSION['solution'];

    // Si tout est correct, victoire
    if (
        $solution["personnage"] == $hyp_pers &&
        $solution["arme"] == $hyp_arme &&
        $solution["piece"] == $hyp_piece
    ) {
        return "gagne";
    }

    // Sinon, déterminer un élément incorrect
    $incorrects = [];

    if ($solution["personnage"] != $hyp_pers) $incorrects[] = "personnage";
    if ($solution["arme"] != $hyp_arme)       $incorrects[] = "arme";
    if ($solution["piece"] != $hyp_piece)     $incorrects[] = "piece";

    // Retourner un indice aléatoire parmi les éléments faux
    return $incorrects[array_rand($incorrects)];
}

function peutFaireHypothese($piece_actuelle) {
    return $_SESSION["derniere_hypothese_piece"] !== $piece_actuelle;
}

function getPersonnageById($sqlite, $id) {
    $id = intval($id);
    $sql = "SELECT * FROM personnages WHERE id_personnage = $id LIMIT 1";
    return $sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
}

function getArmeById($sqlite, $id) {
    $id = intval($id);
    $sql = "SELECT * FROM armes WHERE id_arme = $id LIMIT 1";
    return $sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
}

function getPieceById($sqlite, $id) {
    $id = intval($id);
    $sql = "SELECT * FROM pieces WHERE id_piece = $id LIMIT 1";
    return $sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
}
?>