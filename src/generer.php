<?php
include("connexion1.php");

// traitement quand on clique sur bouton
if(isset($_POST['generer'])) {

    $idformation = $_POST['idformation'];

    $sql = "SELECT idparticipant FROM participation WHERE idformation = $1";
    $result = pg_query_params($conn, $sql, array($idformation));

    while($row = pg_fetch_assoc($result)) {

        $idparticipant = $row['idparticipant'];

        // code unique
        $code = "ATT" . rand(1000,9999);

        // liens QR
        $qr_detail = "http://localhost/xampp/detailformation.php?idformation=$idformation";
        $qr_download = "http://localhost/xampp/download.php?code=$code";

        // fichier pdf
        $pdf = "attestations/att_$code.pdf";

        // insertion DB
        $insert = "INSERT INTO attestation 
        (idparticipant, idformation, code_unique, qr_detail, qr_download, fichier_pdf)
        VALUES ($1, $2, $3, $4, $5, $6)";

        pg_query_params($conn, $insert, array(
            $idparticipant,
            $idformation,
            $code,
            $qr_detail,
            $qr_download,
            $pdf
        ));
    }

    $message = " Attestations générées avec succès !";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Générer Attestations</title>
</head>
<body>

<h2>Génération des attestations</h2>

<?php if(isset($message)) echo "<p>$message</p>"; ?>

<form method="POST">

    <label>Choisir une formation :</label>
    <select name="idformation">

        <?php
        $formations = pg_query($conn, "SELECT * FROM formation");
        while($f = pg_fetch_assoc($formations)) {
            echo "<option value='".$f['idformation']."'>".$f['nomformation']."</option>";
        }
        ?>

    </select>

    <br><br>

    <button type="submit" name="generer">Générer les attestations</button>

</form>

</body>
</html>