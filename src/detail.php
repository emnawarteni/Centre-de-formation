<?php
include("connexion1.php");

if(isset($_GET['idformation'])) {

    $id = $_GET['idformation'];

    $query = "SELECT f.nomformation, f.date_debut, f.date_fin,
                     u.nom, u.prenom
              FROM formation f
              JOIN formateur fo ON f.idformateur = fo.idformateur
              JOIN utilisateur u ON fo.idutilisateur = u.idutilisateur
              WHERE f.idformation = $1";

    $result = pg_query_params($conn, $query, array($id));
    $data = pg_fetch_assoc($result);

    if(!$data) {
        echo " Formation introuvable";
        exit;
    }

} else {
    echo " Aucun ID";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détail Formation</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            text-align: center;
        }

        .card {
            background: white;
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
        }

        p {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="card">

    <h2><?php echo $data['nomformation']; ?></h2>

    <p><strong> Date début :</strong> <?php echo $data['date_debut']; ?></p>
    <p><strong> Date fin :</strong> <?php echo $data['date_fin']; ?></p>

    <p><strong> Formateur :</strong> 
        <?php echo $data['nom'] . " " . $data['prenom']; ?>
    </p>

</div>

</body>
</html>