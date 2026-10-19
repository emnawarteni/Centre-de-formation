<?php
include("connexion.php");

if(isset($_GET['idformateur'])) {
    $idformateur = $_GET['idformateur'];
} else {
    die("Formateur non spécifié");
}

//  traitement
if(isset($_POST['associer'])) {

    if(isset($_POST['formations'])) {

        foreach($_POST['formations'] as $idformation) {

            $query = "UPDATE formation SET idformateur = $1 WHERE idformation = $2";
            pg_query_params($dbconn, $query, array($idformateur, $idformation));
        }
        //  REDIRECTION
        header("Location: listeFormateurs.php?success=1");
        exit();

        echo "<p style='color:green;'> Association faite avec succès</p>";

    } else {
        echo "<p style='color:red;'> Choisissez au moins une formation</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Associer Formateur</title>
</head>
<body>

<h2>Associer Formateur aux Formations</h2>

<form method="POST">

<?php

$res = pg_query($dbconn, "SELECT * FROM formation WHERE idformateur IS NULL");

while($row = pg_fetch_assoc($res)) {
    echo "<input type='checkbox' name='formations[]' value='".$row['idformation']."'> ";
    echo $row['nomformation']."<br>";
}
?>

<br>

<button type="submit" name="associer">Associer</button>

</form>

</body>
</html>