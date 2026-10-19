CREATE TABLE utilisateur (
    idutilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(150)
);
INSERT INTO utilisateur (nom, prenom, email ) VALUES
('Ben Ali', 'Karim', 'karim@gmail.com'),
('Trabelsi', 'Amira', 'amira@gmail.com'),
('Haddad', 'Ali', 'ali@gmail.com'),
('Mansouri', 'Sara', 'sara@gmail.com');
CREATE TABLE formateur (
    idformateur SERIAL PRIMARY KEY,
    idutilisateur INT,
    FOREIGN KEY (idutilisateur) REFERENCES utilisateur(idutilisateur)
);
INSERT INTO formateur (idutilisateur) VALUES
(1),
(2);
CREATE TABLE participant (
    idparticipant SERIAL PRIMARY KEY,
    idutilisateur INT,
    FOREIGN KEY (idutilisateur) REFERENCES utilisateur(idutilisateur)
);
INSERT INTO participant (idutilisateur) VALUES
(3),
(4);
CREATE TABLE formation (
    idformation SERIAL PRIMARY KEY,
    nomformation VARCHAR(150),
    date_debut DATE,
    date_fin DATE,
    idformateur INT,
    FOREIGN KEY (idformateur) REFERENCES formateur(idformateur)
);
INSERT INTO formation (nomformation, date_debut, date_fin, idformateur)VALUES
('Formation PHP', '2025-01-10', '2025-01-20', 1),
('Formation Python', '2026-01-01', '2026-12-30', 2),
('Formation Réseaux', '2025-03-01', '2025-03-10', 1),
('Python Avance','2026-04-10','2026-05-30', 1);
CREATE TABLE participation (
    idparticipation SERIAL PRIMARY KEY,
    idparticipant INT,
    idformation INT,
    presence INT,
    FOREIGN KEY (idparticipant) REFERENCES participant(idparticipant),
    FOREIGN KEY (idformation) REFERENCES formation(idformation)
);
INSERT INTO participation (idparticipant, idformation, presence) VALUES
(1,1,100), -- ✔ حضر
(1,2,100), -- ⏳ en cours
(1,3,40);  -- ❌ غايب
CREATE TABLE attestation (
    idattestation SERIAL PRIMARY KEY,
    idparticipant INT,
    idformation INT,
    code_unique VARCHAR(100),
    FOREIGN KEY (idparticipant) REFERENCES participant(idparticipant),
    FOREIGN KEY (idformation) REFERENCES formation(idformation)
);
INSERT INTO attestation (idparticipant, idformation, code_unique) VALUES
(1,1,'ATT9999');