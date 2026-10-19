<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Formateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Ajouter un Formateur</h2>
    
<?php
include("connexion.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $specialite = htmlspecialchars($_POST['specialite']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $disponibilite = ($_POST['disponibilite'] == "1") ? 'true' : 'false';

    $date_debut = !empty($_POST['date_debut']) ? $_POST['date_debut'] : null;
    $date_fin = !empty($_POST['date_fin']) ? $_POST['date_fin'] : null;

    // validation
    if (!empty($nom) && !empty($prenom) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $query = "INSERT INTO formateur(nom, prenom, specialite, email, disponibilite, date_debut, date_fin)
                  VALUES ($1,$2,$3,$4,$5,$6,$7)";

        $result = pg_query_params($dbconn, $query, array(
            $nom, $prenom, $specialite, $email, $disponibilite, $date_debut, $date_fin
        ));

        if ($result) {
            echo "<div class='message success'>
                     Formateur ajouté avec succès !<br><br>
                    <a href='listeFormateurs.php' class='btn' style='display:block; text-decoration:none; background-color:#2c3e50; color:white; padding:10px; border-radius:5px; text-align:center;'>
                        ⬅ Retour à la liste
                    </a>
                  </div>";
        } else {
            echo "<div class='message error'> Erreur (email déjà utilisé ou problème DB)</div>";
        }

    } else {
        echo "<div class='message error'> Vérifiez les champs</div>";
    }
}
?>

    <form method="POST" onsubmit="return validateDates()">

        <label>Nom :</label>
        <input type="text" name="nom" required>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" required>
        
        <label>Spécialité :</label>
        <input type="text" name="specialite" required>
        
        <label>Email :</label>
        <input type="email" name="email" required>
        
        <label>Disponibilité :</label>
        <select name="disponibilite" id="dispo" onchange="toggleCalendar()">
            <option value="1">Disponible</option>
            <option value="0">Indisponible</option>
        </select>

        <!--  calendrier -->
        <div id="calendar" style="display:none; margin-top:10px;">
            <label>Disponible de :</label>
            <input type="date" name="date_debut">

            <label>à :</label>
            <input type="date" name="date_fin">
        </div>
        
        <button type="submit" class="btn btn-ajouter" style="width:100%">Ajouter le formateur</button>
        <a href="listeFormateurs.php" class="btn btn-annuler" style="display:block; text-decoration:none;">Annuler</a>
    </form>
</div>

<script>
//  afficher calendrier
function toggleCalendar() {
    var dispo = document.getElementById("dispo").value;
    var calendar = document.getElementById("calendar");

    if(dispo == "1") {
        calendar.style.display = "block";
    } else {
        calendar.style.display = "none";
    }
}

//  validation dates
function validateDates() {
    var debut = document.querySelector("input[name='date_debut']").value;
    var fin = document.querySelector("input[name='date_fin']").value;

    if(debut && fin && fin < debut) {
        alert(" Date fin doit être après date début");
        return false;
    }
    return true;
}
</script>

</body>
</html>