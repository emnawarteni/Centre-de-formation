CREATE TABLE formateur(
    idformateur SERIAL PRIMARY KEY,
	nom VARCHAR(100)NOT NULL ,
	prenom VARCHAR (100) NOT NULL,
	specialite VARCHAR(100) NOT NULL ,
	email VARCHAR(100),
	disponibilite BOOLEAN
);
CREATE TABLE formation(
	idformation SERIAL PRIMARY KEY,
	description VARCHAR(100),
	competencesVisees VARCHAR (100),
	prerequis VARCHAR (100),
	duree Date,
	qrCode VARCHAR(255)
);
SELECT * FROM formateur;
INSERT INTO formateur(nom,prenom,specialite,email,disponibilite) VALUES ('Warteni','Emna','BI','warteniemna1@gmail.com','true');
ALTER TABLE formation 
ADD COLUMN idformateur INT;

ALTER TABLE formation 
ADD COLUMN nomformation varchar(20);

ALTER TABLE formation
ADD CONSTRAINT fk_formation_formateur
FOREIGN KEY (idformateur)
REFERENCES formateur(idformateur);

ALTER TABLE formation
ALTER COLUMN idformateur DROP NOT NULL;

UPDATE formation 
SET idformateur = 1 
WHERE idformation = 1;


SELECT * FROM formation;

INSERT INTO formation 
(nomformation, description, competencesVisees, prerequis, duree, qrCode, idformateur) 
VALUES
('PHP Débutant', 'Apprendre les bases du PHP', 'Backend, CRUD', 'Bases informatique', '2025-01-20', NULL, NULL),
('Python Avancé', 'Programmation avancée Python', 'Data, scripting', 'Python de base', '2025-02-15', NULL, NULL),
('Java POO', 'Programmation orientée objet en Java', 'POO, applications', 'Algorithmique', '2025-03-10', NULL, NULL),
('Réseaux', 'Introduction aux réseaux', 'Configuration, TCP/IP', 'Bases réseaux', '2025-04-12', NULL, NULL),
('Cybersécurité', 'Sécurité des systèmes', 'Protection, hacking éthique', 'Bases IT', '2025-05-20', NULL, NULL),
('Data Science', 'Analyse de données', 'ML, statistiques', 'Python + maths', '2025-06-18', NULL, NULL);


INSERT INTO formation 
(nomformation, description, competencesVisees, prerequis, duree, qrCode, idformateur) 
VALUES
('Marketing', 'Apprendre les bases Photographie', 'Backend, CRUD', 'Bases informatique', '2025-02-24', NULL, NULL);
ALTER TABLE formateur
ADD COLUMN date_debut DATE,
ADD COLUMN date_fin DATE;