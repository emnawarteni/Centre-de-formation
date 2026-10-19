<?php
include("connexion1.php");

$idformateur = 1;
$today = date('Y-m-d');

$query = "SELECT * FROM formation WHERE idformateur = $1";
$result = pg_query_params($conn, $query, array($idformateur));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes attestations</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; }
        table { width:80%; margin:30px auto; border-collapse:collapse; background:white; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#2c3e50; color:white; }

        .btn { padding:5px 10px; border-radius:5px; color:white; text-decoration:none; }
        .voir { background:#3498db; }
        .telecharger { background:#2ecc71; }

        .encours { color:orange; }
        .ok { color:green; }
    </style>
</head>

<body>

<h2 style="text-align:center;">📄 Mes attestations </h2>

<table>
<tr>
    <th>Formation</th>
    <th>Statut</th>
    <th>Actions</th>
</tr>

<?php while($row = pg_fetch_assoc($result)) { ?>
<tr>

<td><?php echo $row['nomformation']; ?></td>

<td>
<?php
if($row['date_fin'] > $today)
    echo "<span class='encours'>⏳ En cours</span>";
else
    echo "<span class='ok'>✔ Terminée</span>";
?>
</td>

<td>
<?php if($row['date_fin'] <= $today) { ?>

<a class="btn voir"
href="http://localhost/xampp/voir_formateur.php?idformation=<?php echo $row['idformation']; ?>"
target="_blank">Voir</a>

<a class="btn telecharger"
href="http://localhost/xampp/download_formateur.php?idformation=<?php echo $row['idformation']; ?>">
Télécharger</a>

<br><br>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=http://172.20.10.14/xampp/download_formateur.php?idformation=<?php echo $row['idformation']; ?>">

<?php } else { echo "-"; } ?>
</td>

</tr>
<?php } ?>

</table>

</body>
</html>