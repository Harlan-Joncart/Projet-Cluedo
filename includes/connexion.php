<?php
// Connexion à la base SQLite3
$bdd_fichier = __DIR__ . '/../cluedo.db';

// Vérification que le fichier existe, sinon création automatique
if (!file_exists($bdd_fichier)) {
    // Création d'une nouvelle base SQLite3
    $sqlite = new SQLite3($bdd_fichier);
} else {
    $sqlite = new SQLite3($bdd_fichier);
}

// Optionnel : activer le journal WAL pour les performances
$sqlite->exec('PRAGMA journal_mode = WAL;');

// Optionnel : forcer les résultats associatifs
$sqlite->exec('PRAGMA foreign_keys = ON;');

// Test rapide de connexion
if (!$sqlite) {
    die("Erreur : impossible de se connecter à la base SQLite3.");
}
?>
