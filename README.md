# Plateforme de gestion d'un centre de formation

Projet AGL réalisé en groupe. Ce dépôt contient les modules que j'ai développés (BF3 et BF10), réalisés en PHP et MySQL.

## Contexte
L'application sert à gérer un centre de formation : formations, formateurs, sessions, salles, inscriptions des participants, présences et attestations.

## Mes modules

### BF3 : Gestion des formateurs
L'administrateur peut gérer les formateurs du centre :
- ajouter un nouveau formateur
- mettre à jour ses informations
- supprimer un formateur
- associer chaque formateur aux formations qu'il peut dispenser
- consulter la liste des formateurs et le détail de chacun

### BF10 : Génération des attestations
À la fin d'une formation, le système génère une attestation de participation pour chaque participant. Chaque attestation contient un QR code unique qui permet de vérifier son authenticité et d'accéder aux détails de la formation (nom, dates, formateur). Le participant peut consulter ses attestations et les télécharger en PDF.

## Technologies
- PHP
- MySQL
- HTML / CSS
- FPDF pour la génération des PDF
- XAMPP comme environnement local

## Documentation
Le dossier `docs` contient les diagrammes de classe, les diagrammes de séquence, la spécification des cas d'utilisation et le product backlog.

## Travail de groupe
Les autres modules (inscription et authentification, gestion des formations, sessions, salles, paiement, groupes, présences, notifications) ont été réalisés par les autres membres de l'équipe.
