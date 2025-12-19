-- Base Sqlite


-- Table des personnages
CREATE TABLE personnages (
    id_personnage INTEGER PRIMARY KEY,
    nom_personnage TEXT NOT NULL,
    couleur_personnage TEXT NOT NULL -- Code couleur HTML
);

-- Table des armes
CREATE TABLE armes (
    id_arme INTEGER PRIMARY KEY,
    nom_arme TEXT NOT NULL
);

-- Table des pièces
CREATE TABLE pieces (
    id_piece INTEGER PRIMARY KEY,
    nom_piece TEXT NOT NULL
);

-- Table des portes
CREATE TABLE portes (
    id_piece1 INTEGER,
    id_piece2 INTEGER,
	PRIMARY KEY(id_piece1, id_piece2)
	FOREIGN KEY (id_piece1) REFERENCES pieces(id_piece),
    FOREIGN KEY (id_piece2) REFERENCES pieces(id_piece)
);

-- Insertion des personnages avec couleur
INSERT INTO personnages (id_personnage, nom_personnage, couleur) VALUES
(1, 'Mademoiselle Rose', '#FFC0CB'), -- Rose
(2, 'Colonel Moutarde', '#FFD700'),  -- Jaune (Moutarde)
(3, 'Professeur Violet', '#800080'),  -- Violet
(4, 'Madame Leblanc', '#FFFFFF'),    -- Blanc
(5, 'Monsieur Olive', '#008000'),    -- Vert (Olive)
(6, 'Docteur Pervenche', '#0000FF'); -- Bleu

-- Insertion des armes
INSERT INTO armes (id_arme, nom_arme) VALUES
(1, 'Couteau'),
(2, 'Revolver'),
(3, 'Corde'),
(4, 'Chandelle'),
(5, 'Clé anglaise'),
(6, 'Barre de fer');

-- Insertion des pièces
INSERT INTO pieces (id_piece, nom_piece) VALUES
(1, 'Salon'),
(2, 'Cuisine'),
(3, 'Bibliothèque'),
(4, 'Bureau'),
(5, 'Salle de billard'),
(6, 'Hall'),
(7, 'Salle à manger'),
(8, 'Véranda');

-- Insertion des portes
INSERT INTO portes (id_piece1, id_piece2) VALUES
(6, 1),
(6, 7),
(1, 3),
(1, 5),
(5, 3),
(5, 4),
(5, 8),
(7, 2),
(2, 8);