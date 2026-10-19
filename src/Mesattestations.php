<?php
include("connexion1.php");

//  participant connecté
$idparticipant = 1;

//  formations + attestations
$sql = "SELECT f.idformation, f.nomformation, f.date_debut, f.date_fin, 
               a.code_unique, p.presence
        FROM participation p
        JOIN formation f ON p.idformation = f.idformation
        LEFT JOIN attestation a 
        ON a.idparticipant = p.idparticipant 
        AND a.idformation = f.idformation
        WHERE p.idparticipant = $1";

$result = pg_query_params($conn, $sql, array($idparticipant));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes Attestations</title>
    <link rel="stylesheet" href="style_attestation.css">
</head>
<body>

<div class="container">

    <h1> Mes Attestations</h1>

    <p class="info">
    </p>

    <table>
        <tr>
            <th>Formation</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>

        <?php while($row = pg_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row['nomformation']; ?></td>

            <td>
                <?php echo $row['date_debut']." → ".$row['date_fin']; ?>
            </td>

            <td>
                <?php
                $today = date('Y-m-d');

                if($row['date_fin'] > $today) {
                    echo "<span class='encours'> En cours</span>";
                }
                else if($row['presence'] < 100) {
                    echo "<span class='no'> Non éligible</span>";
                }
                else if($row['code_unique']) {
                    echo "<span class='ok'> Disponible</span>";
                }
                ?>
            </td>

            <td>
                <?php
                if($row['date_fin'] > $today) {
                    echo "<span class='msg'> Formation en cours</span>";
                }
                else if($row['presence'] < 100) {
                    echo "<span class='msg'> Absence détectée</span>";
                }
                else if($row['code_unique']) {
                ?>
                    <a class="btn voir"href="http://localhost/xampp/voir.php?code=<?php echo $row['code_unique']; ?>"
                    target="_blank">Voir</a>
                    <a class="btn telecharger" href="download.php?code=<?php echo $row['code_unique']; ?>">Télécharger</a>
                    <br><br>

                    <img class="qr" 
                    src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=http://172.20.10.14/xampp/download.php?code=<?php echo $row['code_unique']; ?>">
                <?php
                }
                ?>
            
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>